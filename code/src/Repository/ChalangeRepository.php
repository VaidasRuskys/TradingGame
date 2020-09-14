<?php

namespace App\Repository;

use App\Entity\Chalange;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Chalange|null find($id, $lockMode = null, $lockVersion = null)
 * @method Chalange|null findOneBy(array $criteria, array $orderBy = null)
 * @method Chalange[]    findAll()
 * @method Chalange[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChalangeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Chalange::class);
    }

    // /**
    //  * @return Chalange[] Returns an array of Chalange objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Chalange
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
