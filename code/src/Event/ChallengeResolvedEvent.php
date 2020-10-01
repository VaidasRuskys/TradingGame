<?php

namespace App\Event;

use App\Entity\Challenge;
use Symfony\Contracts\EventDispatcher\Event;

class ChallengeResolvedEvent extends Event
{
    public const NAME = 'challenge.resolved';

    /** @var Challenge */
    private $challenge;

    public function __construct(Challenge $challenge)
    {
        $this->challenge = $challenge;
    }

    public function getChallenge(): Challenge
    {
        return $this->challenge;
    }
}