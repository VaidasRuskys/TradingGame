<?php

namespace App\Repository;

use App\Entity\DayChallengeChain;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DayChallengeChain|null find($id, $lockMode = null, $lockVersion = null)
 * @method DayChallengeChain|null findOneBy(array $criteria, array $orderBy = null)
 * @method DayChallengeChain[]    findAll()
 * @method DayChallengeChain[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DayChallengeChainRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DayChallengeChain::class);
    }
}
