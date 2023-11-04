<?php

namespace App\Repository;

use App\Entity\TestResultLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TestResultLog>
 *
 * @method TestResultLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method TestResultLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method TestResultLog[]    findAll()
 * @method TestResultLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TestResultLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TestResultLog::class);
    }

//    /**
//     * @return TestResultLog[] Returns an array of TestResultLog objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TestResultLog
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
