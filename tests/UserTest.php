<?php

namespace App\Tests;

use App\Entity\PostOffice;
use App\Entity\PostRoute;
use App\Entity\RouteRequest;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectRepository;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserTest extends KernelTestCase
{
    private $entityManager;

    public function testFirstNameCanBeCreated()
    {
        $user = new user();
        $user->setFirstname("name");

        $result = 'name';

        $this->assertSame($result, $user->getFirstname());
    }

    public function testLastNameCanBeCreated()
    {
        $user = new user();
        $user->setLastname("name");

        $result = 'name';

        $this->assertSame($result, $user->getLastname());
    }

    public function testEmailCanBeCreated()
    {
        $user = new user();
        $user->setEmail("test@test.nl");

        $result = 'test@test.nl';

        $this->assertSame($result, $user->getEmail());
    }





}
