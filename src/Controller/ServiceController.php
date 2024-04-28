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

    #[Route('/api/service/{id<\d+>}', name: 'service_delete', methods:  ['DELETE'] )]
    public function deleteService(ServiceRepository $serviceRepository, EntityManagerInterface $em, int $id) : JsonResponse
    {
        $service = $serviceRepository->findOneBy(['id' => $id]);

        if ($service) {
            $em->remove($service);
            $em->flush();
            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }
        return new JsonResponse(['status' => 'Service not found'], Response::HTTP_NOT_FOUND);   
    }

    
}
