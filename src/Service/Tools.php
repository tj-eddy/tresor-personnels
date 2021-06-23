<?php
/**
 * Created by PhpStorm.
 * User: Eddy
 * Date: 23/02/2021
 * Time: 08:54
 */

namespace App\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Security;

/**
 * Class Tools
 * @package App\Service
 */
class Tools
{
    /**
     * @var EntityManager
     */
    private $entityManager;
    private $security;

    /**
     * Tools constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security      = $security;
    }

    /**
     * @param $date_value
     * @return string
     * @throws \Exception
     */
    public function getAge($date_value)
    {
        return (new \DateTime())->format('Y') - (new \DateTime($date_value))->format('Y') ;
    }
}