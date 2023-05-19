<?php

namespace App\Entity;

use App\Repository\PostOfficeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostOfficeRepository::class)]
class PostOffice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $kvk = null;

    #[ORM\OneToMany(mappedBy: 'PostOffice', targetEntity: User::class)]
    private Collection $users;

    #[ORM\OneToMany(mappedBy: 'PostOffice', targetEntity: PostRoute::class)]
    private Collection $postRoutes;

    #[ORM\OneToMany(mappedBy: 'postOffice', targetEntity: RouteRequest::class)]
    private Collection $routeRequests;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->postRoutes = new ArrayCollection();
        $this->routeRequests = new ArrayCollection();
    }

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

    public function getKvk(): ?int
    {
        return $this->kvk;
    }

    public function setKvk(int $kvk): self
    {
        $this->kvk = $kvk;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setPostOffice($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getPostOffice() === $this) {
                $user->setPostOffice(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PostRoute>
     */
    public function getPostRoutes(): Collection
    {
        return $this->postRoutes;
    }

    public function addPostRoute(PostRoute $postRoute): self
    {
        if (!$this->postRoutes->contains($postRoute)) {
            $this->postRoutes->add($postRoute);
            $postRoute->setPostOffice($this);
        }

        return $this;
    }

    public function removePostRoute(PostRoute $postRoute): self
    {
        if ($this->postRoutes->removeElement($postRoute)) {
            // set the owning side to null (unless already changed)
            if ($postRoute->getPostOffice() === $this) {
                $postRoute->setPostOffice(null);
            }
        }

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
            $routeRequest->setPostOffice($this);
        }

        return $this;
    }

    public function removeRouteRequest(RouteRequest $routeRequest): self
    {
        if ($this->routeRequests->removeElement($routeRequest)) {
            // set the owning side to null (unless already changed)
            if ($routeRequest->getPostOffice() === $this) {
                $routeRequest->setPostOffice(null);
            }
        }

        return $this;
    }
}
