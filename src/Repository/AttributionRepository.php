<?php

namespace App\Repository;

use App\Entity\Attribution;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;

/**
 * @method Attribution|null find($id, $lockMode = null, $lockVersion = null)
 * @method Attribution|null findOneBy(array $criteria, array $orderBy = null)
 * @method Attribution[]    findAll()
 * @method Attribution[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AttributionRepository extends ServiceEntityRepository
{
    private $security;

    public function __construct(ManagerRegistry $registry, Security $security)
    {
        $this->security = $security;
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
        $_order_by  = $_order_by ? $_order_by : "a.id DESC";
        $attributin = $this->getEntityName();


        $user     = $this->security->getUser();
        $roles    = $user->getRoles();
        $is_admin = in_array('ROLE_SUPERADMIN', $roles);

        $where = "";
        if (!$is_admin) {
            $id_user = $user->getId();
            $where   .= " AND u.id = $id_user";
        }

        $_dql = "SELECT 
                a.status,
                a.numero_tache,
                a.nom_tache,
                DATE_FORMAT(a.date_debut,'%d-%d-%Y %h:%i'),
                DATE_FORMAT(a.date_fin,'%d-%d-%Y %h:%i'),
                u.username,
                a.id as id_attribution
                FROM $attributin a
                LEFT JOIN a.user u 
                WHERE (a.numero_tache LIKE :search 
                OR a.nom_tache LIKE :search 
                OR u.username LIKE :search 
                OR a.date_debut LIKE :search 
                OR a.date_fin LIKE :search ) $where
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

        $user     = $this->security->getUser();
        $roles    = $user->getRoles();
        $is_admin = in_array('ROLE_SUPERADMIN', $roles);

        $where = "";
        if (!$is_admin) {
            $id_user = $user->getId();
            $where   .= " AND u.id = $id_user";
        }
        $_dql = "
            SELECT COUNT (a) as nbTotal 
            FROM $attribution a
            LEFT JOIN a.user u 
            WHERE (a.numero_tache LIKE :search 
                OR a.nom_tache LIKE :search 
                OR u.username LIKE :search 
                OR a.date_debut LIKE :search 
                OR a.date_fin LIKE :search ) $where";

        $_query = $this->_em->createQuery($_dql);
        $_query->setParameter('search', "%$_search%");

        return $_query->getOneOrNullResult()['nbTotal'];
    }

//    public function updateStatusAttribution($new, $attr_id, $old)
//    {
//        dump($new,$old,$attr_id);die;
//        $queryBuilder_new = $this->createQueryBuilder('a');
//        $query_new        = $queryBuilder_new->update('App:Attribution', 'a')
//            ->set('a.date_fin', null)
//            ->set('a.date_debut', new \DateTime())
//            ->set('a.user', ':user')
//            ->set('a.status', 0)
//            ->where('a.id = :id_attr')
//            ->setParameter('id_attr', $attr_id)
//            ->setParameter('user', $new)
//            ->getQuery();
//
//        $queryBuilder_old = $this->createQueryBuilder('a');
//        $query_old        = $queryBuilder_old->update('App:Attribution', 'a')
//            ->set('a.date_fin', new \DateTime())
//            ->set('a.user', ':user')
//            ->set('a.status', 1)
//            ->where('a.id = :id_attr')
//            ->andWhere('a.user = :user')
//            ->setParameter('id_attr', $attr_id)
//            ->setParameter('user', $old)
//            ->getQuery();
//
//        $query_new->execute();
//        $query_old->execute();
//
//        return true;
//    }
}
