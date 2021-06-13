<?php

namespace App\Repository;

use App\Entity\DemandeConge;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DemandeConge|null find($id, $lockMode = null, $lockVersion = null)
 * @method DemandeConge|null findOneBy(array $criteria, array $orderBy = null)
 * @method DemandeConge[]    findAll()
 * @method DemandeConge[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DemandeCongeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DemandeConge::class);
    }

    /**
     * @param $_page
     * @param $_nb_max_page
     * @param $_search
     * @param $_order_by
     * @return array
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function DemandeCongeListArray($_page, $_nb_max_page, $_search, $_order_by)
    {
        $_order_by = $_order_by ? $_order_by : "dc.id DESC";

        $demande_conge = $this->getEntityName();

        $_dql = "SELECT 
                dc.status,
                dc.num_demande,
                u.username,
                dc.nom_interim,
                DATE_FORMAT(dc.date_debut,'%d-%m-%Y à %h:%i'),
                dc.motif,
                dc.type_conge,
                dc.lieu_jouissance,
                dc.id
                FROM $demande_conge dc
                LEFT JOIN dc.user u
                WHERE (
                    dc.status LIKE :search
                    OR dc.num_demande LIKE :search
                    OR u.username LIKE :search
                    OR dc.nom_interim LIKE :search
                    OR dc.date_debut LIKE :search
                    OR dc.motif LIKE :search
                    OR dc.lieu_jouissance LIKE :search
                )
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
        $document_recrutement = $this->getEntityName();

        $_dql = "
            SELECT COUNT (dc) as nbTotal 
            FROM $document_recrutement dc
            LEFT JOIN dc.user u 
            WHERE  (
                    dc.status LIKE :search
                    OR dc.num_demande LIKE :search
                    OR u.username LIKE :search
                    OR dc.nom_interim LIKE :search
                    OR dc.date_debut LIKE :search
                    OR dc.motif LIKE :search
                     OR dc.lieu_jouissance LIKE :search
                )";

        $_query = $this->_em->createQuery($_dql);
        $_query->setParameter('search', "%$_search%");

        return $_query->getOneOrNullResult()['nbTotal'];
    }
}
