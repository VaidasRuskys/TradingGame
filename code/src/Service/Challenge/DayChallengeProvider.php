<?php

namespace App\Service\Challenge;

use App\Entity\DayChallenge;
use App\Repository\DayChallengeRepository;
use App\Service\Challenge\Loader\LoaderInterface;

class DayChallengeProvider
{
    /** @var LoaderInterface[] */
    private $loaders =[];

    /** @var DayChallengeRepository */
    private $dayChallengeRepository;

    /**
     * DayChallengeProvider constructor.
     * @param DayChallengeRepository $dayChallengeRepository
     */
    public function __construct(DayChallengeRepository $dayChallengeRepository)
    {
        $this->dayChallengeRepository = $dayChallengeRepository;
    }

    public function getDayChallenge(): DayChallenge
    {
        $challenge = $this->dayChallengeRepository->getCurrentDayChallenge();
        foreach($this->loaders as $loader) {
            $loader->load($challenge);
        }

        return $challenge;
    }

    public function addLoader(LoaderInterface $loader)
    {
        $this->loaders[] = $loader;
    }
}
