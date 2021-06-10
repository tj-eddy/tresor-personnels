<?php
/**
 * Created by PhpStorm.
 * User: Eddy
 * Date: 23/02/2021
 * Time: 08:54
 */

namespace App\Service;

use App\Entity\BasicData;
use Doctrine\ORM\EntityManager;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\Session\Session;
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

}