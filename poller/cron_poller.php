<?php

//get the data from the .env file
function parseEnvFile($filePath) {
    if (!file_exists($filePath)) {
        throw new Exception("File not found: " . $filePath);
    }

    $env = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $data = [];

    foreach ($env as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue; // Skip comments
        }
        
        list($key, $value) = explode('=', $line, 2);
        $data[trim($key)] = trim($value, '"');
    }

    return $data;
}

//create the connection string from the database URL in the .env file
function createConnectionString($databaseUrl) {
    $components = parse_url($databaseUrl);

    if ($components === false) {
        throw new Exception("Error parsing the database URL.");
    }
    $scheme = $components['scheme'];

    if ($scheme !== 'postgresql') {
        throw new Exception("The database scheme is not 'postgresql'.");
    }

    $connectionString = sprintf(
        "pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s",
        $components['host'],
        $components['port'],
        ltrim($components['path'], '/'),
        $components['user'],
        $components['pass']
    );

    return $connectionString;
}

//connect to the server via SSH and execute a command
function sshconn($server, $port, $user, $pass, $cmd) {
    
    $ssh = ssh2_connect($server, $port);
    // if (!$ssh) {
    //     echo "Failed to connect to the server";
    //     exit;
    // }

    // Authenticate with the server
    if (!ssh2_auth_password($ssh, $user, $pass)) {
        echo "Authentication failed";
//        exit;
    }

    // Execute commands on the server
    echo "Executing command: $cmd\n";
    $stream = ssh2_exec($ssh, $cmd);
    stream_set_blocking($stream, true);
    $output = stream_get_contents($stream);
    fclose($stream);

    // Close the SSH connection
    ssh2_disconnect($ssh);
    return $output;
}


//***************    begin of the programm     ***************//
// To avoid running the script multiple times, we will create a lock file
// Check if the script is already running
$lockFile = dirname(__FILE__) . "/cron_poller.lock";

if (file_exists($lockFile)) {
    echo "Another instance of the script is already running. Stopping execution.";
    exit;
}

// Create a lock file to indicate that the script is running
file_put_contents($lockFile, '');


//****************  main code  ****************
$env = dirname(__FILE__)."/../.env";

try {
    $envData = parseEnvFile($env);
    
    if (!isset($envData['DATABASE_URL'])) {
        throw new Exception("DATABASE_URL not found in .env file.");
    }
    
    $databaseUrl = $envData['DATABASE_URL'];
    $connectionString = createConnectionString($databaseUrl);
    
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
    
    // Remove the lock file after the script finishes execution
    unlink($lockFile);
    exit -1;
}


try {
    $dbconn = new PDO($connectionString);
    $dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $query = "SELECT * FROM server";
    $servers = $dbconn->query($query);
    
    if (!$servers) {
        echo "Error executing query: " . $dbconn->errorInfo()[2];
        
        // Remove the lock file after the script finishes execution
        unlink($lockFile);
        exit -1;
    }
    
    //get all servers
    while ($server_row = $servers->fetch(PDO::FETCH_ASSOC)) {
        echo $server_row['id']."  ".$server_row['server_name']."\n";

        //get all services for the server
        $services = $dbconn->query("select id, server_id_id, service_name, start_cmd, stop_cmd, is_run from service where server_id_id=".$server_row['id']);
        $service_status = true;  //check if service is running
        while ($service_row = $services->fetch(PDO::FETCH_ASSOC)){
            echo "     ".$service_row['id']."  ".$service_row['service_name']."\n";

            //get all tests for the service
            $tests = $dbconn->query("select t.*, st.* from service_tests st, tests t where st.tests_id=t.id and st.service_id=".$service_row['id']);
            while ($test_row = $tests->fetch(PDO::FETCH_ASSOC)) 
            {
                $service_test_log = "";
                $service_test_log .= "            ".$test_row['id']."  ".$test_row['test_name']." ".$server_row['fqdn'].":".$server_row['port']."\n";   

                $ssh_result = sshconn($server_row['fqdn'], $server_row['port'], $server_row['login'], $server_row['password_key'], $test_row['test_code']);
                $service_test_log .= "                   ";
                $service_test_log .= "Expected result: ".$test_row['expected_answer']."\n";

                $service_test_log .= "                   ";
                $service_test_log .= "Test result: ".$ssh_result."\n";
                if ($test_row['expected_answer'] != $ssh_result && $service_status == true) { //if even one test fails, the service is not running
                    $service_status = false;
                }
                

                $inst = $dbconn->prepare("INSERT into test_result_log(id, service_id_id, test_id_id, datetime_execution, execution_answer, status) ".
                                 " values( nextval('test_result_log_id_seq'), :service_id, :test_id, now(), :execution_answer, :status)");
                $inst->bindParam(':service_id', $service_row['id']);
                $inst->bindParam(':test_id', $test_row['id']);
                $inst->bindParam(':execution_answer', $service_test_log);
                $status = ($test_row['expected_answer'] == $ssh_result) ? 'true' : 'false';
                echo "    Status: ".$status."\n";
                $inst->bindParam(':status', $status);
                $inst->execute();
            }
            
            if ($service_status) {
                echo "Service status: OK\n";
                $dbconn->query("UPDATE service SET is_run='true' WHERE id=".$service_row['id']);
            } else {
                echo "Service status: FAIL\n";
                $dbconn->query("UPDATE service SET is_run='false' WHERE id=".$service_row['id']);
            }
        }
    }
    
    $servers->closeCursor();
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
    
    // Remove the lock file after the script finishes execution
    unlink($lockFile);
    exit -1;
}

//**************** end main code  ****************


// Remove the lock file after the script finishes execution
unlink($lockFile);
?>
