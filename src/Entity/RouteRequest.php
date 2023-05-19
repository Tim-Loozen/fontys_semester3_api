<?php

namespace App\Entity;

use App\Repository\RouteRequestRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RouteRequestRepository::class)]
class RouteRequest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'routeRequests')]
    private ?user $user = null;

    #[ORM\ManyToOne(inversedBy: 'routeRequests')]
    private ?PostRoute $PostRoute = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'routeRequests')]
    private ?postOffice $postOffice = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $status = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPostRoute(): ?PostRoute
    {
        return $this->PostRoute;
    }

    public function setPostRoute(?PostRoute $PostRoute): self
    {
        $this->PostRoute = $PostRoute;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPostOffice(): ?postOffice
    {
        return $this->postOffice;
    }

    public function setPostOffice(?postOffice $postOffice): self
    {
        $this->postOffice = $postOffice;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }
}
