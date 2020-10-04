<?php

namespace App\Service\Challenge\Loader;

use App\Entity\DayChallenge;

interface LoaderInterface
{
    public function load(DayChallenge $dayChallenge): void;
}