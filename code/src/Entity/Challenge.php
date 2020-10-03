<?php

namespace App\Entity;

use App\Repository\ChalangeRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 *
 * @ORM\Table(
 *     uniqueConstraints={
 *        @UniqueConstraint(name="user_unique_day_challenge",
 *            columns={"user", "day_challenge_id"})
 *    })
 * @ORM\Entity(repositoryClass=ChalangeRepository::class)
 */
class Challenge
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $dayChallengeId;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $stock;

    /**
     * @ORM\Column(type="float")
     */
    private $atPrice;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $endPrice;

    /**
     * @ORM\Column(type="datetime")
     */
    private $atTime;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $endTime;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $action;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $result;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDayChallengeId()
    {
        return $this->dayChallengeId;
    }

    public function setDayChallengeId($dayChallengeId): self
    {
        $this->dayChallengeId = $dayChallengeId;

        return $this;
    }

    public function getStock(): ?string
    {
        return $this->stock;
    }

    public function setStock(string $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getAtPrice(): ?float
    {
        return $this->atPrice;
    }

    public function setAtPrice(float $atPrice): self
    {
        $this->atPrice = $atPrice;

        return $this;
    }

    public function getEndPrice(): ?float
    {
        return $this->endPrice;
    }

    public function setEndPrice(float $endPrice): self
    {
        $this->endPrice = $endPrice;

        return $this;
    }

    public function getAtTime(): ?\DateTimeInterface
    {
        return $this->atTime;
    }

    public function setAtTime(\DateTimeInterface $atTime): self
    {
        $this->atTime = $atTime;

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->endTime;
    }

    public function setEndTime(?\DateTimeInterface $endTime): self
    {
        $this->endTime = $endTime;

        return $this;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function setAction($action): self
    {
        $this->action = $action;

        return $this;
    }

    public function getResult(): ?string
    {
        return $this->result;
    }

    public function setResult(string $result): self
    {
        $this->result = $result;

        return $this;
    }

    public function getUser(): ?string
    {
        return $this->user;
    }

    public function setUser(string $user): self
    {
        $this->user = $user;

        return $this;
    }
}
