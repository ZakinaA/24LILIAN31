<?php

namespace App\Repository;

use App\Entity\Insciption;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Insciption>
 *
 * @method Insciption|null find($id, $lockMode = null, $lockVersion = null)
 * @method Insciption|null findOneBy(array $criteria, array $orderBy = null)
 * @method Insciption[]    findAll()
 * @method Insciption[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InsciptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Insciption::class);
    }

//    /**
//     * @return Insciption[] Returns an array of Insciption objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Insciption
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
