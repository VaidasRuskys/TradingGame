<?php

namespace App\Service\Challenge;

class DayChallengeProvider
{
    public function getDayChallenge(): array
    {
        return [
            'id' => 1,
            'stock' => 'MSFT',
            'price' => 205.72,
        ];
    }
}