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


    public function pointageListArray($_page, $_nb_max_page, $_search, $_order_by)
    {
        $_order_by = $_order_by ? $_order_by : "ptg.id DESC";

        $pointage = $this->getEntityName();

        $_dql = "SELECT 
                usr.username,
                DATE_FORMAT(ptg.date_arrive_matinee,'%d/%m/%Y') as date_auj,
                DATE_FORMAT(ptg.date_arrive_matinee,'%h:%i:%s'),
                DATE_FORMAT(ptg.heure_sortie_matinee,'%h:%i:%s'),
                DATE_FORMAT(ptg.heure_arrivee_ap,'%h:%i:%s'),
                DATE_FORMAT(ptg.heure_sortie_ap,'%h:%i:%s')
                FROM $pointage ptg LEFT JOIN ptg.user usr
                WHERE  (usr.username LIKE :search 
                OR ptg.date_arrive_matinee LIKE :search 
                OR ptg.heure_sortie_matinee LIKE :search 
                OR ptg.heure_arrivee_ap LIKE :search 
                OR ptg.heure_sortie_ap LIKE :search)
                ORDER BY $_order_by";

        $_query = $this->_em->createQuery($_dql);
        $_query->setParameter('search', "%$_search%")
            ->setFirstResult($_page)
            ->setMaxResults($_nb_max_page);

        return [$_query->getResult(), $this->compteData($_search)];
    }

    /**
     * @param $_search
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function compteData($_search)
    {
        $pointage = $this->getEntityName();

        $_dql = "
            SELECT COUNT (usr) as nbTotal 
            FROM $pointage ptg LEFT JOIN ptg.user usr
            WHERE (usr.username LIKE :search 
                OR ptg.date_arrive_matinee LIKE :search 
                OR ptg.heure_sortie_matinee LIKE :search 
                OR ptg.heure_arrivee_ap LIKE :search 
                OR ptg.heure_sortie_ap LIKE :search)";

        $_query = $this->_em->createQuery($_dql);
        $_query->setParameter('search', "%$_search%");

        return $_query->getOneOrNullResult()['nbTotal'];
    }

    public function getMaxIdPtg($user_id)
    {
        $ptg   = $this->getEntityName();
        $_query = $this->_em->createQuery("select max(p.id)  as max_id_ptg
                                            from $ptg p left join p.user u 
                                            where u.id = $user_id");

        return $_query->getOneOrNullResult()['max_id_ptg'];
    }
}

