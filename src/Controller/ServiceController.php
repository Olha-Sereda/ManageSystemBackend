<?php

namespace App\Controller;

use App\Entity\Server;
use App\Entity\Service;
use App\Repository\ServerRepository;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ServiceController extends AbstractController
{
    //connect to the server via SSH and execute a command
    public function sshconn($server, $port, $user, $pass, $cmd) {
    
    $ssh = ssh2_connect($server, $port);
    
    // Authenticate with the server
    $output = "";
    if (ssh2_auth_password($ssh, $user, $pass) && $ssh) 
    {    
        // Execute commands on the server
        $stream = ssh2_exec($ssh, $cmd);
        stream_set_blocking($stream, true);
        $output = stream_get_contents($stream);
        fclose($stream);

        // Close the SSH connection
        ssh2_disconnect($ssh);
    }
    return $output;
}

    
    #[Route('/api/server/{id<\d+>}', name: 'app_services', methods: 'GET')]
    public function showServices(ServiceRepository $serviceRepository,  int $id) : JsonResponse
    {
        
       $services = $serviceRepository->findByServerId($id);

        $data = [];
        foreach ($services as $service) {
            $data[] = [
                'id' => $service->getId(),
                'service_name' => $service->getServiceName(),
                'server_id' => $service->getServerId(),
            ];
        }
        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/api/server/', name: 'service_add', methods: ['POST'])]
    public function addService(Request $request, EntityManagerInterface $em, ServerRepository $serverRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
    
        $service_name = $data['service_name'];
        $server_id = $request->query->get('id');
    
        if (empty($service_name)) {
            return new JsonResponse(['status' => 'Service name is required'], Response::HTTP_BAD_REQUEST);
        }
    
        $server = $serverRepository->find($server_id);
        if (!$server) {
            return new JsonResponse(['status' => 'Server not found'], Response::HTTP_NOT_FOUND);
        }
    
        $service = new Service();
        $service->setServiceName($service_name);
        $service->setServerId($server);
    
        $em->persist($service);
        $em->flush();
    
        return new JsonResponse(['status' => 'Service added successfully'], Response::HTTP_CREATED);
    }
    #[Route('/api/service/{serviceId<\d+>}', name: 'service_delete', methods: ['DELETE'])]
    public function deleteService(int $serviceId, ServiceRepository $serviceRepository, EntityManagerInterface $em): JsonResponse
    {
        $service = $serviceRepository->find($serviceId);

        if (!$service) {
            return new JsonResponse(['status' => 'Service not found'], Response::HTTP_NOT_FOUND);
        }

        $em->remove($service);
        $em->flush();

        return new JsonResponse(['status' => 'Service deleted successfully'], Response::HTTP_OK);
    }

    #[Route('/api/service/{serviceId<\d+>}/start', name: 'service_start', methods: ['GET'])]
    public function startService(int $serviceId, ServiceRepository $serviceRepository, EntityManagerInterface $em, ServerRepository $serverRepository): JsonResponse
    {
        $service = $serviceRepository->find($serviceId);

        if (!$service) {
            return new JsonResponse(['status' => 'Service not found'], Response::HTTP_NOT_FOUND);
        }
        //TODO: Implement the logic to start the service
        $run_cmd = $service->getStartCmd();
        $serverId = $service->getServerId();
        $server = $serverRepository->find($serverId);
        $serverFqdn = $server->getFqdn();
        $serverPort = $server->getPort();
        $serverLogin = $server->getLogin();
        $serverPasswordKey = $server->getPasswordKey();
//        echo "||".$run_cmd."||\n";
        $output = trim($this->sshconn($serverFqdn, $serverPort, $serverLogin, $serverPasswordKey, $run_cmd));
//        echo "||".$output."||\n";
//        if ($output=="true"){
        $service->setRun(true);
        $em->flush();
        return new JsonResponse(['status' => 'Service started successfully'], Response::HTTP_OK);
//        }
//        return new JsonResponse(['status' => 'Error during service start'], Response::HTTP_OK);
    }

    #[Route('/api/service/{serviceId<\d+>}/stop', name: 'service_stop', methods: ['GET'])]
    public function stopService(int $serviceId, ServiceRepository $serviceRepository, EntityManagerInterface $em, ServerRepository $serverRepository): JsonResponse
    {
         $service = $serviceRepository->find($serviceId);

        if (!$service) {
            return new JsonResponse(['status' => 'Service not found'], Response::HTTP_NOT_FOUND);
        }
        //TODO: Implement the logic to start the service
        $run_cmd = $service->getStopCmd();
        $serverId = $service->getServerId();
        $server = $serverRepository->find($serverId);
        $serverFqdn = $server->getFqdn();
        $serverPort = $server->getPort();
        $serverLogin = $server->getLogin();
        $serverPasswordKey = $server->getPasswordKey();
//        echo "||".$run_cmd."||\n";
        $output = trim($this->sshconn($serverFqdn, $serverPort, $serverLogin, $serverPasswordKey, $run_cmd));
//        echo "||".$output."||\n";
//        if ($output=="true"){
        $service->setRun(false);
        $em->flush();
        return new JsonResponse(['status' => 'Service stopped successfully'], Response::HTTP_OK);
//        }
//        return new JsonResponse(['status' => 'Error during service stop'], Response::HTTP_OK);
    }
}
