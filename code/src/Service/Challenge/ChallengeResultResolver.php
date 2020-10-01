<?php

namespace App\Service\Challenge;

use App\Entity\Challenge;
use App\Event\ChallengeResolvedEvent;
use App\StockPrice\Providers\FinnhubStockPriceProvider;
use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ChallengeResultResolver
{
    private $entityManager;

    private $stockPriceProvider;

    private $eventDispatcher;

    public function __construct(
        EntityManager $entityManager,
        FinnhubStockPriceProvider $stockPriceProvider,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->entityManager = $entityManager;
        $this->stockPriceProvider = $stockPriceProvider;
        $this->eventDispatcher = $eventDispatcher;
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

        $challengeResolvedEvent = new ChallengeResolvedEvent($challenge);
        $this->eventDispatcher->dispatch($challengeResolvedEvent, ChallengeResolvedEvent::NAME);

        try {
            $this->entityManager->persist($challenge);
            $this->entityManager->flush($challenge);

            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }
}
