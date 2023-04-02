<?php

namespace App\Entity;

use App\Repository\PackageCompenstaionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PackageCompenstaionRepository::class)]
class PackageCompenstaion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $base_compensation = null;

    #[ORM\Column]
    private ?float $weight_compenstation = null;

    #[ORM\Column]
    private ?float $size_compensation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBaseCompensation(): ?float
    {
        return $this->base_compensation;
    }

    public function setBaseCompensation(float $base_compensation): self
    {
        $this->base_compensation = $base_compensation;

        return $this;
    }

    public function getWeightCompenstation(): ?float
    {
        return $this->weight_compenstation;
    }

    public function setWeightCompenstation(float $weight_compenstation): self
    {
        $this->weight_compenstation = $weight_compenstation;

        return $this;
    }

    public function getSizeCompensation(): ?float
    {
        return $this->size_compensation;
    }

    public function setSizeCompensation(float $size_compensation): self
    {
        $this->size_compensation = $size_compensation;

        return $this;
    }
}
