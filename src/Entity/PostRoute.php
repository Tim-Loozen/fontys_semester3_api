<?php

namespace App\Entity;

use App\Repository\PostRouteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\ManyToOne(inversedBy: 'postRoutes')]
    private ?PostOffice $PostOffice = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\ManyToOne(inversedBy: 'postRoutes')]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'PostRoute', targetEntity: RouteRequest::class)]
    private Collection $routeRequests;


    public function __construct()
    {
        $this->status = "active";
        $this->routeRequests = new ArrayCollection();
    }

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

    public function getPostOffice(): ?PostOffice
    {
        return $this->PostOffice;
    }

    public function setPostOffice(?PostOffice $PostOffice): self
    {
        $this->PostOffice = $PostOffice;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, RouteRequest>
     */
    public function getRouteRequests(): Collection
    {
        return $this->routeRequests;
    }

    public function addRouteRequest(RouteRequest $routeRequest): self
    {
        if (!$this->routeRequests->contains($routeRequest)) {
            $this->routeRequests->add($routeRequest);
            $routeRequest->setPostRoute($this);
        }

        return $this;
    }

    public function removeRouteRequest(RouteRequest $routeRequest): self
    {
        if ($this->routeRequests->removeElement($routeRequest)) {
            // set the owning side to null (unless already changed)
            if ($routeRequest->getPostRoute() === $this) {
                $routeRequest->setPostRoute(null);
            }
        }

        return $this;
    }


}
