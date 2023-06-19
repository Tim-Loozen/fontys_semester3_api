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

class PostRouteTest extends KernelTestCase
{

    public function testPostRouteTimeCanBeCreated(): void
    {
        $postRoute = new postRoute();
        $postRoute->setTime(55);

        $result = "55";

        $this->assertSame($result, $postRoute->getTime());
    }
    public function testPostRouteDistance(): void
    {
        $postRoute = new postRoute();
        $postRoute->setDistance(55);

        $result = "55";

        $this->assertSame($result, $postRoute->getDistance());
    }
    public function testPostRouteStartPoint(): void
    {
        $postRoute = new postRoute();
        $postRoute->setStartpoint("eindhoven");

        $result = "eindhoven";

        $this->assertSame($result, $postRoute->getStartpoint());
    }





}
