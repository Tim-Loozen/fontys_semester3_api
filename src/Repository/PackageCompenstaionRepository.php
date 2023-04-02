<?php

namespace App\Repository;

use App\Entity\PackageCompenstaion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PackageCompenstaion>
 *
 * @method PackageCompenstaion|null find($id, $lockMode = null, $lockVersion = null)
 * @method PackageCompenstaion|null findOneBy(array $criteria, array $orderBy = null)
 * @method PackageCompenstaion[]    findAll()
 * @method PackageCompenstaion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PackageCompenstaionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PackageCompenstaion::class);
    }

    public function save(PackageCompenstaion $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PackageCompenstaion $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return PackageCompenstaion[] Returns an array of PackageCompenstaion objects
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

//    public function findOneBySomeField($value): ?PackageCompenstaion
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
