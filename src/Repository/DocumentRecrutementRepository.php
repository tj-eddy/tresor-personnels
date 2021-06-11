<?php

namespace App\Repository;

use App\Entity\DocumentRecrutement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @method DocumentRecrutement|null find($id, $lockMode = null, $lockVersion = null)
 * @method DocumentRecrutement|null findOneBy(array $criteria, array $orderBy = null)
 * @method DocumentRecrutement[]    findAll()
 * @method DocumentRecrutement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocumentRecrutementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DocumentRecrutement::class);
    }

    /**
     * @param $_page
     * @param $_nb_max_page
     * @param $_search
     * @param $_order_by
     * @return array
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function documentRecrutementListArray($_page, $_nb_max_page, $_search, $_order_by)
    {
        $_order_by = $_order_by ? $_order_by : "dm.id DESC";

        $document_recrutement = $this->getEntityName();

        $_dql = "SELECT 
                u.username,
                dm.num_doc,
                dm.type_doc,
                dm.date_doc,
                dm.corps,
                dm.indice,
                dm.categorie,
                dm.grade,
                dm.id
                FROM $document_recrutement dm
                LEFT JOIN dm.user u
                WHERE dm.is_deleted = 0
                AND (
                    dm.num_doc LIKE :search
                    OR dm.type_doc LIKE :search
                    OR dm.date_doc LIKE :search
                    OR dm.corps LIKE :search
                    OR dm.indice LIKE :search
                    OR dm.categorie LIKE :search
                    OR dm.grade LIKE :search
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
            SELECT COUNT (dm) as nbTotal 
            FROM $document_recrutement dm
            WHERE dm.is_deleted is null OR  dm.is_deleted = 0
            AND (
                    dm.num_doc LIKE :search
                    OR dm.type_doc LIKE :search
                    OR dm.date_doc LIKE :search
                    OR dm.corps LIKE :search
                    OR dm.indice LIKE :search
                    OR dm.categorie LIKE :search
                    OR dm.grade LIKE :search
                )";

        $_query = $this->_em->createQuery($_dql);
        $_query->setParameter('search', "%$_search%");

        return $_query->getOneOrNullResult()['nbTotal'];
    }

}
