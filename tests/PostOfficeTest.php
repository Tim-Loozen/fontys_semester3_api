<?php

namespace App\Tests;

use App\Entity\PostOffice;
use App\Entity\PostRoute;
use App\Entity\RouteRequest;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PostOfficeTest extends KernelTestCase
{
    public function testPostOfficeNameCanBeCreated(): void
    {
        $postOffice = new PostOffice();
        $postOffice->setName("test");

        $result = "test";

        $this->assertSame($result, $postOffice->getName());
    }

    public function testPostOfficeKvkCanBeCreated(): void
    {
        $postOffice = new PostOffice();
        $postOffice->setKvk(01234);

        $result = 01234;

        $this->assertSame($result, $postOffice->getKvk());
    }






}
