<?php

namespace App\Repository;

use App\Entity\TitreConge;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TitreConge|null find($id, $lockMode = null, $lockVersion = null)
 * @method TitreConge|null findOneBy(array $criteria, array $orderBy = null)
 * @method TitreConge[]    findAll()
 * @method TitreConge[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TitreCongeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TitreConge::class);
    }

    // /**
    //  * @return TitreConge[] Returns an array of TitreConge objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TitreConge
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
