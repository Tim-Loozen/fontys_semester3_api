<?php

namespace App\Entity;

use App\Repository\PostRouteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostRouteRepository::class)]
class PostRoute
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $distance = null;

    #[ORM\Column(nullable: true)]
    private ?int $time = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $startpoint = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $endpoint = null;

    #[ORM\Column(nullable: true)]
    private ?float $earnings = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDistance(): ?int
    {
        return $this->distance;
    }

    public function setDistance(?int $distance): self
    {
        $this->distance = $distance;

        return $this;
    }

    public function getTime(): ?int
    {
        return $this->time;
    }

    public function setTime(?int $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getStartpoint(): ?string
    {
        return $this->startpoint;
    }

    public function setStartpoint(?string $startpoint): self
    {
        $this->startpoint = $startpoint;

        return $this;
    }

    public function getEndpoint(): ?string
    {
        return $this->endpoint;
    }

    public function setEndpoint(?string $endpoint): self
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    public function getEarnings(): ?float
    {
        return $this->earnings;
    }

    public function setEarnings(?float $earnings): self
    {
        $this->earnings = $earnings;

        return $this;
    }
}
