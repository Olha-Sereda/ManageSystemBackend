<?php

namespace App\Controller;

use App\Entity\Server;
use App\Entity\Service;
use App\Repository\ServiceRepository;
use App\Repository\ServerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;


class ServiceController extends AbstractController
{
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
    
    
}
