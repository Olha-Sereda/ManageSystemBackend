<?php

namespace App\Controller;

use App\Entity\TestResultLog;
use App\Repository\TestResultLogRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TestResultLogController extends AbstractController
{
    #[Route('/api/service/{serviceId<\d+>}/resultlog', name: 'app_serviceresultlog', methods: 'GET')]
    public function showServiceLog(ManagerRegistry $manager, int $serviceId ) : JsonResponse
    {
        $resultlogs = $manager->getRepository(TestResultLog::class)->findBy(['service_id' => $serviceId], ['id' => 'DESC'], 50);
        $data = [];
        foreach ($resultlogs as $resultlog) {
            $data[] = [
                'id' => $resultlog->getId(),
                'execution_answer' => $resultlog->getExecutionAnswer(),
                'datetime_execution' => $resultlog->getDatetimeExecution(),
                'status' => $resultlog->isStatus(),
            ];
        }
        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/api/test/{testId<\d+>}/resultlog', name: 'app_testresultlog', methods: 'GET')]
    public function showTesteLog(ManagerRegistry $manager, int $testId ) : JsonResponse
    {
        $resultlogs = $manager->getRepository(TestResultLog::class)->findBy(['test_id' => $testId], ['id' => 'DESC'], 50);
        $data = [];
        foreach ($resultlogs as $resultlog) {
            $data[] = [
                'id' => $resultlog->getId(),
                'execution_answer' => $resultlog->getExecutionAnswer(),
                'datetime_execution' => $resultlog->getDatetimeExecution(),
                'status' => $resultlog->isStatus(),
            ];
        }
        return new JsonResponse($data, Response::HTTP_OK);
    }
    
}