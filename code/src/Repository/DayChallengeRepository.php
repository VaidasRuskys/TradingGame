<?php

namespace App\Repository;

use App\Entity\DayChallenge;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DayChallenge|null find($id, $lockMode = null, $lockVersion = null)
 * @method DayChallenge|null findOneBy(array $criteria, array $orderBy = null)
 * @method DayChallenge[]    findAll()
 * @method DayChallenge[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DayChallengeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DayChallenge::class);
    }

    public function getCurrentDayChallenge(): ?DayChallenge
    {
        return $this->createQueryBuilder('dc')
            ->andWhere('dc.startTime < :now')
            ->andWhere('dc.endTime > :now')
            ->setParameter('now', new \DateTime())
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    // /**
    //  * @return DayChallenge[] Returns an array of DayChallenge objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DayChallenge
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
