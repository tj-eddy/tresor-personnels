<?php

namespace App\Controller;

use App\Entity\Pointage;
use App\Repository\DemandeCongeRepository;
use App\Repository\PointageRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class DashboardController extends AbstractController
{
    private $userRepository;
    private $security;
    private $pointageRepository;
    private $demandeCongeRepository;

    public function __construct(UserRepository $userRepository,
                                Security $security,
                                PointageRepository $pointageRepository,
                                DemandeCongeRepository $demandeCongeRepository
    )
    {
        $this->userRepository         = $userRepository;
        $this->security               = $security;
        $this->demandeCongeRepository = $demandeCongeRepository;
        $this->pointageRepository     = $pointageRepository;

    }

    /**
     * @Route("/dashboard", name="admin_dashboard")
     */
    public function index(): Response
    {
//        $session = new Session();
//        $session->set('user_id', $this->getUser()->getId());

        $conge_waiting = $this->demandeCongeRepository->findBy([
            'user'   => $this->getUser(),
            'status' => 0
        ]);
        $conge_accepte = $this->demandeCongeRepository->findBy([
            'user'   => $this->getUser(),
            'status' => 1
        ]);
        $conge_cancel  = $this->demandeCongeRepository->findBy([
            'user'   => $this->getUser(),
            'status' => 2
        ]);

        $_is_admin = in_array('ROLE_SUPERADMIN', $this->security->getUser()->getRoles());

        return $this->render('dashboard/index.html.twig', [
            'total_emp'     => count($this->userRepository->findBy([
                'is_deleted' => 0,
            ])),
            'conge_encours' => $_is_admin ? count($this->demandeCongeRepository->findBy([
                'status' => 1
            ])) : count($conge_accepte),
            'conge_attente' => $_is_admin ? count($this->demandeCongeRepository->findBy([
                'status' => 0
            ])) : count($conge_waiting),
            'conge_annule'  => $_is_admin ? count($this->demandeCongeRepository->findBy([
                'status' => 2
            ])) : count($conge_cancel)
        ]);
    }
}
