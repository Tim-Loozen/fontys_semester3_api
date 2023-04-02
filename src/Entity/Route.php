<?php

namespace App\Entity;

use App\Repository\RouteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RouteRepository::class)]
class Route
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $distance = null;

    #[ORM\Column]
    private ?float $compensation = null;

    #[ORM\Column]
    private ?int $time = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDistance(): ?float
    {
        return $this->distance;
    }

    public function setDistance(float $distance): self
    {
        $this->distance = $distance;

        return $this;
    }

    public function getCompensation(): ?float
    {
        return $this->compensation;
    }

    public function setCompensation(float $compensation): self
    {
        $this->compensation = $compensation;

        return $this;
    }

    public function getTime(): ?int
    {
        return $this->time;
    }

    public function setTime(int $time): self
    {
        $this->time = $time;

        return $this;
    }
}
