<?php

namespace App\Entity;

use App\Repository\DayChallengeChainRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DayChallengeChainRepository::class)
 */
class DayChallengeChain
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     */
    private $startingBudget;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getStartingBudget(): ?float
    {
        return $this->startingBudget;
    }

    public function setStartingBudget(float $startingBudget): self
    {
        $this->startingBudget = $startingBudget;

        return $this;
    }
}
