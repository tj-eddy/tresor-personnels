<?php

namespace App\Controller;

use App\Repository\DemandeCongeRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="admin_dashboard")
     */
    public function index(UserRepository $userRepository,
                          Security $security,
                          DemandeCongeRepository $demandeCongeRepository): Response
    {
        $session = new Session();
        $session->set('user_id', $this->getUser()->getId());

        $conge_waiting = $demandeCongeRepository->findBy([
            'user'   => $this->getUser(),
            'status' => 0
        ]);
        $conge_accepte = $demandeCongeRepository->findBy([
            'user'   => $this->getUser(),
            'status' => 1
        ]);
        $conge_cancel  = $demandeCongeRepository->findBy([
            'user'   => $this->getUser(),
            'status' => 2
        ]);
        $_is_admin     = in_array('ROLE_SUPERADMIN', $security->getUser()->getRoles());

        return $this->render('dashboard/index.html.twig', [
            'total_emp'     => count($userRepository->findBy([
                'is_deleted' => 0,
            ])),
            'conge_encours' => $_is_admin ? count($demandeCongeRepository->findBy([
                'status' => 1
            ])) : count($conge_accepte),
            'conge_attente' => $_is_admin ? count($demandeCongeRepository->findBy([
                'status' => 0
            ])) : count($conge_waiting),
            'conge_annule'  => $_is_admin ? count($demandeCongeRepository->findBy([
                'status' => 2
            ])) : count($conge_cancel)
        ]);
    }
}
