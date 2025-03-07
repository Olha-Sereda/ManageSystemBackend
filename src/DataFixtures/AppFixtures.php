<?php

namespace App\DataFixtures;

use App\Entity\Server;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $server1 = new Server();
        $server1->setServerName('Guru');
        $server1->setFqdn('fqdn for Guru');
        $server1->setIpAddress('255.255.144.16');
        $server1->setLogin('olav');
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

        $manager->flush();
    }
}
