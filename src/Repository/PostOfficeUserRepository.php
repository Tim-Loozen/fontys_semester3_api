<?php

namespace App\Repository;

use App\Entity\PostOfficeUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PostOfficeUser>
 *
 * @method PostOfficeUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostOfficeUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostOfficeUser[]    findAll()
 * @method PostOfficeUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostOfficeUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostOfficeUser::class);
    }

    public function save(PostOfficeUser $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PostOfficeUser $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return PostOfficeUser[] Returns an array of PostOfficeUser objects
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

//    public function findOneBySomeField($value): ?PostOfficeUser
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
