<?php

namespace App\Controller;

use App\Entity\Tests;
use App\Repository\TestsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;


class TestsController extends AbstractController
{
    #[Route('/api/tests', name: 'app_tests', methods: 'GET')]
    public function showTests(TestsRepository $testsRepository) : JsonResponse
    {
        $tests = $testsRepository->findAll();
        $data = [];
        foreach ($tests as $test) {
            $data[] = [
                'id' => $test->getId(),
                'test_name' => $test->getTestName(),
                'test_code' => $test->getTestCode(),
                'expected_answer' => $test->getExpectedAnswer(),
            ];
        }
        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/api/test', name: 'test_add', methods: ['POST'])]
    public function addTest(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
    
        $test_name = $data['test_name'];
        $test_code = $data['test_code'];
        $expected_answer = $data['expected_answer'];
    
        if (empty($test_name) || empty($test_code) || empty($expected_answer)) {
            return new JsonResponse(['status' => 'All fields are required'], Response::HTTP_BAD_REQUEST);
        }
    
        $test = new Tests();
        $test->setTestName($test_name);
        $test->setTestCode($test_code);
        $test->setExpectedAnswer($expected_answer);
    
        $em->persist($test);
        $em->flush();
    
        return new JsonResponse(['status' => 'test added successfully'], Response::HTTP_CREATED);
    }

    #[Route('/api/test/{testId}', name: 'test_delete', methods: ['DELETE'])]
    public function deleteTest(int $testId, TestsRepository $testsRepository, EntityManagerInterface $em): JsonResponse
    {
        $test = $testsRepository->find($testId);
    
        if (!$test) {
            return new JsonResponse(['status' => 'Test not found'], Response::HTTP_NOT_FOUND);
        }
    
        $em->remove($test);
        $em->flush();
    
        return new JsonResponse(['status' => 'Test deleted successfully'], Response::HTTP_OK);
    }
    
    
}
