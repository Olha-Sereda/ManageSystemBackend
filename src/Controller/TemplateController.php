<?php

namespace App\Controller;

use App\Entity\Template;
use App\Repository\TemplateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;


class TemplateController extends AbstractController
{
    #[Route('/api/templates', name: 'app_templates', methods: 'GET')]
    public function showTemplates(TemplateRepository $templateRepository) : JsonResponse
    {
        $templates = $templateRepository->findAll();
        $data = [];
        foreach ($templates as $template) {
            $data[] = [
                'id' => $template->getId(),
                'template_name' => $template->getTemplateName(),
                'test_code' => $template->getTestCode(),
                'expected_answer' => $template->getExpectedAnswer(),
            ];
        }
        return new JsonResponse($data, Response::HTTP_OK);
    }

    // #[Route('/api/server/', name: 'service_add', methods: ['POST'])]
    // public function addService(Request $request, EntityManagerInterface $em, ServerRepository $serverRepository): JsonResponse
    // {
    //     $data = json_decode($request->getContent(), true);
    
    //     $service_name = $data['service_name'];
    //     $server_id = $request->query->get('id');
    
    //     if (empty($service_name)) {
    //         return new JsonResponse(['status' => 'Service name is required'], Response::HTTP_BAD_REQUEST);
    //     }
    
    //     $server = $serverRepository->find($server_id);
    //     if (!$server) {
    //         return new JsonResponse(['status' => 'Server not found'], Response::HTTP_NOT_FOUND);
    //     }
    
    //     $service = new Service();
    //     $service->setServiceName($service_name);
    //     $service->setServerId($server);
    
    //     $em->persist($service);
    //     $em->flush();
    
    //     return new JsonResponse(['status' => 'Service added successfully'], Response::HTTP_CREATED);
    // }
    // #[Route('/api/service/{serviceId<\d+>}', name: 'service_delete', methods: ['DELETE'])]
    // public function deleteService(int $serviceId, ServiceRepository $serviceRepository, EntityManagerInterface $em): JsonResponse
    // {
    //     $service = $serviceRepository->find($serviceId);

    //     if (!$service) {
    //         return new JsonResponse(['status' => 'Service not found'], Response::HTTP_NOT_FOUND);
    //     }

    //     $em->remove($service);
    //     $em->flush();

    //     return new JsonResponse(['status' => 'Service deleted successfully'], Response::HTTP_OK);
    // }
    
}
