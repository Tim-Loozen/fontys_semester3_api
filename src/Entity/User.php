<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Security\Http\Authenticator\AuthenticatorInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $apiToken = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $license_plate = null;

    #[ORM\Column(nullable: true)]
    private ?float $hourly_rate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $work_area = null;

    #[ORM\Column]
    private ?bool $is_admin = null;

    #[ORM\Column(length: 255)]
    private ?string $position = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?PostOffice $PostOffice = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $PhoneNumber = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: PostRoute::class)]
    private Collection $postRoutes;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: RouteRequest::class)]
    private Collection $routeRequests;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $MFAKey = null;

    public function __construct()
    {
        $this->postRoutes = new ArrayCollection();
        $this->routeRequests = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getApiToken(): ?string
    {
        return $this->apiToken;
    }

    public function setApiToken(?string $apiToken): self
    {
        $this->apiToken = $apiToken;

        return $this;
    }

    public function getLicensePlate(): ?string
    {
        return $this->license_plate;
    }

    public function setLicensePlate(string $license_plate): self
    {
        $this->license_plate = $license_plate;

        return $this;
    }

    public function getHourlyRate(): ?float
    {
        return $this->hourly_rate;
    }

    public function setHourlyRate(?float $hourly_rate): self
    {
        $this->hourly_rate = $hourly_rate;

        return $this;
    }

    public function getWorkArea(): ?string
    {
        return $this->work_area;
    }

    public function setWorkArea(?string $work_area): self
    {
        $this->work_area = $work_area;

        return $this;
    }

    public function serialize()
    {
        return [
            "firstname" => $this->firstname,
            "lastname" => $this->lastname,
            "email" => $this->email,
            "postCompany" => $this->getPostOffice()?->getId(),
            "is_admin" => $this->isIsAdmin()
        ];
    }

    public function isIsAdmin(): ?bool
    {
        return $this->is_admin;
    }

    public function setIsAdmin(bool $is_admin): self
    {
        $this->is_admin = $is_admin;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(string $position): self
    {
        $this->position = $position;

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

    public function getPhoneNumber(): ?string
    {
        return $this->PhoneNumber;
    }

    public function setPhoneNumber(?string $PhoneNumber): self
    {
        $this->PhoneNumber = $PhoneNumber;

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
            $postRoute->setUser($this);
        }

        return $this;
    }

    public function removePostRoute(PostRoute $postRoute): self
    {
        if ($this->postRoutes->removeElement($postRoute)) {
            // set the owning side to null (unless already changed)
            if ($postRoute->getUser() === $this) {
                $postRoute->setUser(null);
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
            $routeRequest->setUser($this);
        }

        return $this;
    }

    public function removeRouteRequest(RouteRequest $routeRequest): self
    {
        if ($this->routeRequests->removeElement($routeRequest)) {
            // set the owning side to null (unless already changed)
            if ($routeRequest->getUser() === $this) {
                $routeRequest->setUser(null);
            }
        }

        return $this;
    }

    public function getMFAKey(): ?string
    {
        return $this->MFAKey;
    }

    public function setMFAKey(?string $MFAKey): self
    {
        $this->MFAKey = $MFAKey;

        return $this;
    }

}
