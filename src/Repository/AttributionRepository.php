<?php

namespace App\Repository;

use App\Entity\Attribution;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Attribution|null find($id, $lockMode = null, $lockVersion = null)
 * @method Attribution|null findOneBy(array $criteria, array $orderBy = null)
 * @method Attribution[]    findAll()
 * @method Attribution[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AttributionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Attribution::class);
    }

    /**
     * @return int|mixed|string|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getMaxTaskID()
    {
        $attribution = $this->getEntityName();

        $_query = $this->_em->createQuery("select 
                                            max(a.id) 
                                            from $attribution a");

        return $_query->getOneOrNullResult()[1];
    }

    public function attributionListArray($_page, $_nb_max_page, $_search, $_order_by)
    {
        $_order_by = $_order_by ? $_order_by : "a.id DESC";

        $attributin = $this->getEntityName();

        $_dql = "SELECT 
                u.status_tache,
                a.numero_tache,
                a.nom_tache,
                DATE_FORMAT(a.date_debut,'%d-%d-%Y'),
                DATE_FORMAT(a.date_fin,'%d-%d-%Y'),
                u.username,
                u.id,
                a.id as id_attribution
                FROM $attributin a
                LEFT JOIN a.user u 
                WHERE (a.numero_tache LIKE :search 
                OR a.nom_tache LIKE :search 
                OR a.date_debut LIKE :search 
                OR a.date_fin LIKE :search )
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
        $attribution = $this->getEntityName();

        $_dql = "
            SELECT COUNT (a) as nbTotal 
            FROM $attribution a
            LEFT JOIN a.user u 
            WHERE (a.numero_tache LIKE :search 
                OR a.nom_tache LIKE :search 
                OR u.username LIKE :search 
                OR a.date_debut LIKE :search 
                OR a.date_fin LIKE :search )";

        $_query = $this->_em->createQuery($_dql);
        $_query->setParameter('search', "%$_search%");

        return $_query->getOneOrNullResult()['nbTotal'];
    }

    public function updateStatusAttribution($new, $attr_id, $old)
    {
        $queryBuilder_new = $this->createQueryBuilder('a');
        $query_new    = $queryBuilder_new->update('App:Attribution', 'a')
            ->set('a.date_fin', ':date_fin')
            ->set('a.user', ':user')
            ->where('a.id = :id_attr')
            ->setParameter('date_fin', new \DateTime())
            ->setParameter('id_attr', $attr_id)
            ->setParameter('user', $new)
            ->getQuery();
        $queryBuilder_old = $this->createQueryBuilder('a');
        $query_old = $queryBuilder_old  ->update('App:Attribution', 'a')
            ->set('a.date_debut', ':date_debut')
            ->set('a.user', ':user')
            ->where('a.id = :id_attr')
            ->andWhere('a.user = :user')
            ->setParameter('date_debut', new \DateTime())
            ->setParameter('id_attr', $attr_id)
            ->setParameter('user', $old)
            ->getQuery();

        $query_new->execute();
        $query_old->execute();

        return true;
    }
}
