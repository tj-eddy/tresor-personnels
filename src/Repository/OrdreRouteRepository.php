<?php

namespace App\Repository;

use App\Entity\OrdreRoute;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrdreRoute|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrdreRoute|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrdreRoute[]    findAll()
 * @method OrdreRoute[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrdreRouteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrdreRoute::class);
    }

    /**
     * function getSumDecompteOR
     * @param $id
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getSumDecompteOR($id)
    {
        $ordre_route  = $this->getEntityName();
        $_query = $this->_em->createQuery("select 
                                            sum(ord.decompte_or)  as sum_dor
                                            from $ordre_route ord 
                                            left join ord.user u 
                                            where u.id = $id");

        return $_query->getOneOrNullResult()['sum_dor'];
    }
}
