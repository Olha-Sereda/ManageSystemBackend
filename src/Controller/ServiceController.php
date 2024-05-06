<?php

namespace App\Controller;

use App\Entity\Server;
use App\Entity\Service;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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


    #[Route('/api/service', name: 'service_add', methods: ['POST'])]
    public function addService(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
    
        $service_name = $data['service_name'];
    
        if (empty($service_name)) {
            return new JsonResponse(['status' => 'Service name is required'], Response::HTTP_BAD_REQUEST);
        }
    
        $service = new Service();
        $service->setServiceName($service_name);
    
        $em->persist($service);
        $em->flush();
    
        return new JsonResponse(['status' => 'Service added successfully'], Response::HTTP_CREATED);
    }
    
}
