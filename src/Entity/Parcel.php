<?php

namespace App\Entity;

use App\Repository\ParcelRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParcelRepository::class)]
class Parcel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $width = null;

    #[ORM\Column]
    private ?float $Height = null;

    #[ORM\Column]
    private ?float $depth = null;

    #[ORM\Column]
    private ?float $weight = null;

    #[ORM\Column]
    private ?bool $insured = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWidth(): ?float
    {
        return $this->width;
    }

    public function setWidth(float $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight(): ?float
    {
        return $this->Height;
    }

    public function setHeight(float $Height): self
    {
        $this->Height = $Height;

        return $this;
    }

    public function getDepth(): ?float
    {
        return $this->depth;
    }

    public function setDepth(float $depth): self
    {
        $this->depth = $depth;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function isInsured(): ?bool
    {
        return $this->insured;
    }

    public function setInsured(bool $insured): self
    {
        $this->insured = $insured;

        return $this;
    }
}
