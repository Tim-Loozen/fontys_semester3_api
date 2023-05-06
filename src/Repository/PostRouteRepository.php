<?php

namespace App\Repository;

use App\Entity\PostRoute;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PostRoute>
 *
 * @method PostRoute|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostRoute|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostRoute[]    findAll()
 * @method PostRoute[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRouteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostRoute::class);
    }

    public function save(PostRoute $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PostRoute $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getRoutesByUser(User $user)
    {
        return $this->createQueryBuilder("pr")
            ->leftJoin("pr.PostOffice","po")
            ->where("po.id = :postOfficeId")
            ->setParameter("postOfficeId", $user->getPostOffice())
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return PostRoute[] Returns an array of PostRoute objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PostRoute
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
