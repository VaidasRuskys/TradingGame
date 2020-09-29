<?php

namespace App\Service\Challenge;

use App\Entity\Challenge;
use App\StockPrice\Providers\FinnhubStockPriceProvider;
use Doctrine\ORM\EntityManager;

class ChallengeResultResolver
{
    private $entityManager;

    private $stockPriceProvider;

    public function __construct(EntityManager $entityManager, FinnhubStockPriceProvider $stockPriceProvider)
    {
        $this->entityManager = $entityManager;
        $this->stockPriceProvider = $stockPriceProvider;
    }

    public function resolve(Challenge $challenge): bool
    {
        $result = null;
        $price = $this->stockPriceProvider->getPrice($challenge->getStock());

        if ($challenge->getAction() == 'buy') {
            $result = $price > $challenge->getAtPrice() ? 'success' : 'failed';
        }

        if ($challenge->getAction() == 'sell') {
            $result = $price < $challenge->getAtPrice() ? 'success' : 'failed';
        }

        if (null == $result) {
            return false;
        }

        $challenge
            ->setResult($result)
            ->setEndTime(new \DateTime())
            ->setEndPrice($price)
        ;

        //todo Create event

        try {
            $this->entityManager->persist($challenge);
            $this->entityManager->flush($challenge);

            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }
}
