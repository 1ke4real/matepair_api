<?php

namespace App\Repository;

use App\Entity\Message;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Message>
 *
 * @method Message|null find($id, $lockMode = null, $lockVersion = null)
 * @method Message|null findOneBy(array $criteria, array $orderBy = null)
 * @method Message[]    findAll()
 * @method Message[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }

    public function findMessageSend(int $id): ArrayCollection
    {
        $qb = $this->createQueryBuilder('m')
           ->select('m')
            ->where('m.sender = :id')
            ->setParameter('id', $id)
            ->orderBy('m.id', 'ASC')
            ->getQuery()
            ->getResult();
        return new ArrayCollection($qb);
    }
    public function findMessageReceive(int $id): ArrayCollection
    {
        $qb = $this->createQueryBuilder('m')
           ->select('m')
            ->where('m.receiver = :id')
            ->setParameter('id', $id)
            ->orderBy('m.id', 'ASC')
            ->getQuery()
            ->getResult();
        return new ArrayCollection($qb);
    }
//    /**
//     * @return Message[] Returns an array of Message objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Message
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
