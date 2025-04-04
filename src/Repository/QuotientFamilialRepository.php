<?php

namespace App\Repository;

use App\Entity\QuotientFamilial;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<QuotientFamilial>
 *
 * @method QuotientFamilial|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuotientFamilial|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuotientFamilial[]    findAll()
 * @method QuotientFamilial[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuotientFamilialRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuotientFamilial::class);
    }

//    /**
//     * @return QuotientFamilial[] Returns an array of QuotientFamilial objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('q.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?QuotientFamilial
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
