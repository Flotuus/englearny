<?php

namespace App\Repository;

use App\Entity\RealiseTest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RealiseTest|null find($id, $lockMode = null, $lockVersion = null)
 * @method RealiseTest|null findOneBy(array $criteria, array $orderBy = null)
 * @method RealiseTest[]    findAll()
 * @method RealiseTest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RealiseTestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RealiseTest::class);
    }

    // /**
    //  * @return RealiseTest[] Returns an array of RealiseTest objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RealiseTest
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
