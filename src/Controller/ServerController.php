<?php

namespace App\Controller;

use App\Entity\Server;
use App\Repository\ServerRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ServerController extends AbstractController
{
    #[Route('/api/servers', name: 'app_server', methods: 'GET')]
    public function index(ManagerRegistry $manager) : JsonResponse
    {
        $servers = $manager->getRepository(Server::class)->findAll();
        $data = [];
        foreach ($servers as $server) {
            $data[] = [
                'id' => $server->getId(),
                'server_name' => $server->getServerName(),
                'fqdn' => $server->getFqdn(),
                'ip_address' => $server->getIpAddress(),
                'login' => $server->getLogin(),
                'password_key' => $server->getPasswordKey(),
            ];
        }
        return new JsonResponse($data, Response::HTTP_OK);
    }
    
}
