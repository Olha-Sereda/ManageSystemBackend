<?php

namespace App\Controller;

use App\Repository\ServerRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;

class ServerController extends AbstractController
{
    #[Route('/api/server', name: 'app_server', methods: 'GET')]
    public function index(ServerRepository $server_rep, SerializerInterface $serializer): Response
    {
        $servers = $server_rep->findAll();
        //dd($servers);
        //dd($servers->findOneBy(['server_name' => 'Guru']));
        // return $this->render(
        //     'server/index.html.twig', 
        //     ['servers' => $servers]
        // );

        $context = (new ObjectNormalizerContextBuilder())->withGroups('api_output')->toArray();
        $json = new JsonResponse($serializer->normalize($servers), 200);
        return $json;
        
    }
    
}
