<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    /**
     * @param $_page
     * @param $_nb_max_page
     * @param $_search
     * @param $_order_by
     * @return array
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function userListArray($_page, $_nb_max_page, $_search, $_order_by)
    {
        $_order_by = $_order_by ? $_order_by : "user.id DESC";

        $user = $this->getEntityName();

        $_dql = "SELECT 
                user.Profil,
                user.matricule ,
                user.username ,
                user.prenom ,
                user.cin,
                user.date_start_service,
                user.id
                FROM $user user
                WHERE user.is_deleted is null OR  user.is_deleted = 0
                AND (user.username LIKE :search 
                OR user.email LIKE :search 
                OR user.roles LIKE :search)
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
        $user = $this->getEntityName();

        $_dql = "
            SELECT COUNT (user) as nbTotal 
            FROM $user user
            WHERE user.is_deleted is null OR  user.is_deleted = 0
            AND (user.username LIKE :search 
                    OR user.matricule LIKE :search 
                    OR user.cin LIKE :search 
                    OR user.prenom LIKE :search 
                    OR user.date_start_service LIKE :search 
                    OR user.email LIKE :search)";

        $_query = $this->_em->createQuery($_dql);
        $_query->setParameter('search', "%$_search%");

        return $_query->getOneOrNullResult()['nbTotal'];
    }

    /**
     * @param $term
     * @return mixed
     */
    public function userSelectArray($term)
    {
        $entity = $this->getEntityName();
        $_dql   = "SELECT u.id, u.username
                FROM $entity u
                WHERE u.username LIKE :term";
        $_query = $this->_em->createQuery($_dql);
        $_query->setParameter('term', "%$term%");

        return $_query->getResult();
    }

    public function getMaxIdUserByUser($user_id)
    {
        $user   = $this->getEntityName();
        $_query = $this->_em->createQuery("select max(u.id)  as max_id_user
                                            from $user u 
                                            where u.id = $user_id");

        return $_query->getOneOrNullResult()['max_id_user'];
    }
}