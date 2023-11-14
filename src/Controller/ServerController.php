<?php

namespace App\Controller;

use App\Repository\ServerRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ServerController extends AbstractController
{
    #[Route('/server', name: 'app_server')]
    public function index(ServerRepository $servers): Response
    {
        //dd($servers->findOneBy(['server_name' => 'Guru']));
        return $this->render('server/index.html.twig', [
            'controller_name' => 'ServerController',
        ]);
    }
}
