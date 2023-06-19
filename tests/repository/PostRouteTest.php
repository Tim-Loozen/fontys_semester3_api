<?php

namespace App\Tests\repository;

use App\Entity\PostOffice;
use App\Entity\PostRoute;

use App\Entity\RouteRequest;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class PostRouteTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;
    public function testSearchById()
    {
        $postRoute = $this->entityManager
            ->getRepository(PostRoute::class)
            ->findOneBy(['id' => '1'])
        ;

        $this->assertSame(322, $postRoute->getTime());
    }
}
