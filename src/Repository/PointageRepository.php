<?php

namespace App\Repository;

use App\Entity\Pointage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Pointage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pointage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pointage[]    findAll()
 * @method Pointage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PointageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pointage::class);
    }

    public function getMaxIdPtg($user_id)
    {
        $ptg   = $this->getEntityName();
        $_query = $this->_em->createQuery("select max(p.id)  as max_id_ptg
                                            from $ptg p left join p.user u 
                                            where u.id = $user_id");

        return $_query->getOneOrNullResult()['max_id_ptg'] ?? 0;
    }
}

