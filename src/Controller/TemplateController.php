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

    #[Route('/api/template/', name: 'template_add', methods: ['POST'])]
    public function addTemplate(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
    
        $template_name = $data['template_name'];
        $test_code = $data['test_code'];
        $expected_answer = $data['expected_answer'];
    
        if (empty($template_name) || empty($test_code) || empty($expected_answer)) {
            return new JsonResponse(['status' => 'All fields are required'], Response::HTTP_BAD_REQUEST);
        }
    
        $template = new Template();
        $template->setTemplateName($template_name);
        $template->setTestCode($test_code);
        $template->setExpectedAnswer($expected_answer);
    
        $em->persist($template);
        $em->flush();
    
        return new JsonResponse(['status' => 'Template added successfully'], Response::HTTP_CREATED);
    }

    #[Route('/api/template/{templateId}', name: 'template_delete', methods: ['DELETE'])]
    public function deleteTemplate(int $templateId, TemplateRepository $templateRepository, EntityManagerInterface $em): JsonResponse
    {
        $template = $templateRepository->find($templateId);
    
        if (!$template) {
            return new JsonResponse(['status' => 'Template not found'], Response::HTTP_NOT_FOUND);
        }
    
        $em->remove($template);
        $em->flush();
    
        return new JsonResponse(['status' => 'Template deleted successfully'], Response::HTTP_OK);
    }
    
    
}
