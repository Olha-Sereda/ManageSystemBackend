<?php

namespace App\DataFixtures;

use App\Entity\Tests;
use App\Entity\Server;
use App\Entity\Service;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ServerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $server1 = new Server();
        $server1->setServerName('Guru');
        $server1->setFqdn('fqdn for Guru');
        $server1->setIpAddress('255.255.144.16');
        $server1->setLogin('Olav');
        $server1->setPasswordKey('FujFuj37~_gaq');
        $manager->persist($server1);

        $server2 = new Server();
        $server2->setServerName('Joda');
        $server2->setFqdn('fqdn for Joda');
        $server2->setIpAddress('195.255.195.120');
        $server2->setLogin('Anna');
        $server2->setPasswordKey('KarKar37~_gaq');
        $manager->persist($server2);

        $server3 = new Server();
        $server3->setServerName('Karl');
        $server3->setFqdn('fqdn for Karl');
        $server3->setIpAddress('161.167.150.12');
        $server3->setLogin('Anna');
        $server3->setPasswordKey('HuliHuli37~_gaq');
        $manager->persist($server3);

        $server4 = new Server();
        $server4->setServerName('Snape');
        $server4->setFqdn('fqdn for Snape');
        $server4->setIpAddress('250.167.184.1');
        $server4->setLogin('Elza');
        $server4->setPasswordKey('KraKra37~_gaq');
        $manager->persist($server4);

        $server5 = new Server();
        $server5->setServerName('Lemon');
        $server5->setFqdn('fqdn for Lemon');
        $server5->setIpAddress('250.136.164.8');
        $server5->setLogin('Mirinda');
        $server5->setPasswordKey('KraKra37~_gaq');
        $manager->persist($server5);

        $server6 = new Server();
        $server6->setServerName('Watermelon');
        $server6->setFqdn('fqdn for Watermelon');
        $server6->setIpAddress('250.167.184.1');
        $server6->setLogin('Love');
        $server6->setPasswordKey('KraKra37~_gaq');
        $manager->persist($server6);

        $server7 = new Server();
        $server7->setServerName('Last Summer');
        $server7->setFqdn('fqdn for Last Summer');
        $server7->setIpAddress('250.176.164.18');
        $server7->setLogin('Joe');
        $server7->setPasswordKey('KraKra37~_gaq');
        $manager->persist($server7);

        $server8 = new Server();
        $server8->setServerName('Jesus Superstar');
        $server8->setFqdn('fqdn for Jesus Superstar');
        $server8->setIpAddress('145.161.194.4');
        $server8->setLogin('Mimi');
        $server8->setPasswordKey('KraKra37~_gaq');
        $manager->persist($server8);

        $server9 = new Server();
        $server9->setServerName('KISS');
        $server9->setFqdn('fqdn for KISS');
        $server9->setIpAddress('150.126.174.1');
        $server9->setLogin('Mumu');
        $server9->setPasswordKey('KraKra37~_gaq');
        $manager->persist($server9);

        $server10 = new Server();
        $server10->setServerName('Hello');
        $server10->setFqdn('fqdn for Hello');
        $server10->setIpAddress('250.167.184.1');
        $server10->setLogin('Elza');
        $server10->setPasswordKey('KraKra37~_gaq');
        $manager->persist($server10);

        $server11 = new Server();
        $server11->setServerName('World');
        $server11->setFqdn('fqdn for World');
        $server11->setIpAddress('250.136.164.8');
        $server11->setLogin('Mirinda');
        $server11->setPasswordKey('KraKra37~_gaq');
        $manager->persist($server11);

        $manager->flush();
        
        $service1 = new Service();
        $service1->setServiceName('USOS');
        $service1->setServerId($server1);
        $manager->persist($service1);

        $service2 = new Service();
        $service2->setServiceName('Wierzba');
        $service2->setServerId($server1);
        $manager->persist($service2);

        $service3 = new Service();
        $service3->setServiceName('Luk');
        $service3->setServerId($server2);
        $manager->persist($service3);

        $service4 = new Service();
        $service4->setServiceName('Karol');
        $service4->setServerId($server2);
        $manager->persist($service4);

        $service5 = new Service();
        $service5->setServiceName('Sony');
        $service5->setServerId($server2);
        $manager->persist($service5);

        $service6 = new Service();
        $service6->setServiceName('Sony');
        $service6->setServerId($server3);
        $manager->persist($service6);
        
        $service7 = new Service();
        $service7->setServiceName('Life');
        $service7->setServerId($server3);
        $manager->persist($service7);

        $service8 = new Service();
        $service8->setServiceName('Mirror');
        $service8->setServerId($server4);
        $manager->persist($service8);

        $userrep = $manager->getRepository(User::class);
        dd($userrep->findAll());
        
       $test1 = new Tests();
       $test1->setTestName('Math');
       $test1->setTestCode('Code code code');
       $test1->setDatetimeUpdate(null);
       $test1->setEnabled(true);
       $test1->setUserId($userrep->findOneByUserMail("user0@example.com"));
       $manager->persist($test1);


        $manager->flush();
        

    }
}
