<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Enum\MatchStatus;
use App\Repository\MatcheRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MatcheRepository::class)]
#[ApiResource]
class Matche
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, enumType: MatchStatus::class, options: ['default' => MatchStatus::WAITING])]
    private ?MatchStatus $status = null;

    #[ORM\ManyToOne(inversedBy: 'first')]
    private ?User $user_first = null;

    #[ORM\ManyToOne(inversedBy: 'second')]
    private ?User $user_second = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?MatchStatus
    {
        return $this->status;
    }

    public function setStatus(MatchStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getUserFirst(): ?User
    {
        return $this->user_first;
    }

    public function setUserFirst(?User $user_first): static
    {
        $this->user_first = $user_first;

        return $this;
    }

    public function getUserSecond(): ?User
    {
        return $this->user_second;
    }

    public function setUserSecond(?User $user_second): static
    {
        $this->user_second = $user_second;

        return $this;
    }
}
