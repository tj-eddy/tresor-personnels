<?php

namespace App\Repository;

use App\Entity\FactureSoin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FactureSoin|null find($id, $lockMode = null, $lockVersion = null)
 * @method FactureSoin|null findOneBy(array $criteria, array $orderBy = null)
 * @method FactureSoin[]    findAll()
 * @method FactureSoin[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FactureSoinRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FactureSoin::class);
    }

    // /**
    //  * @return FactureSoin[] Returns an array of FactureSoin objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FactureSoin
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
