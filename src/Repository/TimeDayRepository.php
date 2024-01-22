<?php

namespace App\Repository;

use App\Entity\TimeDay;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TimeDay>
 *
 * @method TimeDay|null find($id, $lockMode = null, $lockVersion = null)
 * @method TimeDay|null findOneBy(array $criteria, array $orderBy = null)
 * @method TimeDay[]    findAll()
 * @method TimeDay[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TimeDayRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TimeDay::class);
    }

//    /**
//     * @return TimeDay[] Returns an array of TimeDay objects
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

//    public function findOneBySomeField($value): ?TimeDay
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
