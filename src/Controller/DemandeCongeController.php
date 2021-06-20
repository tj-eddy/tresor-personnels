<?php

namespace App\Controller;

use App\Entity\DemandeConge;
use App\Form\DemandeCongeType;
use App\Repository\DemandeCongeRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/demande/conge")
 */
class DemandeCongeController extends AbstractController
{
    /**
     * @Route("/", name="demande_conge_index", methods={"GET"})
     */
    public function index(DemandeCongeRepository $demandeCongeRepository): Response
    {
        if (!$this->isGranted('ROLE_SUPERADMIN')) {
            return $this->redirectToRoute('demande_conge_new');
        }
        return $this->render('demande_conge/index.html.twig');
    }

    /**
     * @Route("/ajax-list", name="admin_conge_ajax_list")
     */
    public function ajaxList(Request $_request, DemandeCongeRepository $demandeCongeRepository)
    {
        $_page        = $_request->query->get('start');
        $_nb_max_page = $_request->query->get('length');
        $_search      = $_request->query->get('search')['value'];
        $_order_by    = $_request->query->get('order_by');

        $datas = $demandeCongeRepository->DemandeCongeListArray($_page, $_nb_max_page, $_search, $_order_by);

        return new JsonResponse([
            'recordsTotal'    => $datas[1],
            'recordsFiltered' => $datas[1],
            'data'            => array_map(function ($_val) {
                return array_values($_val);
            }, $datas[0])
        ]);
    }

    /**
     * @Route("/new", name="demande_conge_new", methods={"GET","POST"})
     */
    public function new(Request $request, DemandeCongeRepository $demandeCongeRepository): Response
    {
        if ($this->isGranted('ROLE_SUPERADMIN')) {
           return $this->redirectToRoute('demande_conge_index');
        }

        $demandeConge = new DemandeConge();
        $form         = $this->createForm(DemandeCongeType::class, $demandeConge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($demandeConge);
            $entityManager->flush();

            return $this->redirectToRoute('demande_conge_index');
        }

        return $this->render('demande_conge/new.html.twig', [
            'demande_conge' => $demandeConge,
            'form'          => $form->createView(),
            'last_id'       => $demandeCongeRepository->getMaxID()
        ]);
    }

    /**
     * @Route("/show/{id}", name="demande_conge_show", methods={"GET"})
     */
    public function show(DemandeConge $demandeConge): Response
    {
        return $this->render('demande_conge/show.html.twig', [
            'demande_conge' => $demandeConge,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="demande_conge_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, DemandeConge $demandeConge): Response
    {
        $form = $this->createForm(DemandeCongeType::class, $demandeConge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('demande_conge_index');
        }

        return $this->render('demande_conge/edit.html.twig', [
            'demande_conge' => $demandeConge,
            'form'          => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="demande_conge_delete", methods={"DELETE"})
     */
    public function delete(Request $request, DemandeConge $demandeConge): Response
    {
        if ($this->isCsrfTokenValid('delete' . $demandeConge->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($demandeConge);
            $entityManager->flush();
        }

        return $this->redirectToRoute('demande_conge_index');
    }

    /**
     * @Route("/validate-conge", name="ajax_validation_conge")
     * @param Request $request
     */
    public function validateConge(Request $request,
                                  DemandeCongeRepository $demandeCongeRepository,
                                  UserRepository $userRepository, MailerInterface $mailer
    )
    {

        $conge_id     = $request->request->get('conge_id');
        $jour_demande = $request->request->get('jour_demande');
        $user_id      = $request->request->get('user_id');
        $user         = $userRepository->find($user_id);

        $email = (new Email())
            ->from('dtsitohina@yahoo.fr')
            ->to($demandeCongeRepository->find($conge_id)->getUser()->getEmail())
            ->subject('Demande de congé')
            ->text('Demande de congé payé')
            ->html('<p>Bonjour ' . $this->getUser()->getUsername() . ' <br> Votre demande de congé est validé ! </p>');

        $mailer->send($email);

        $user->setCongeInitial((int)$user->getCongeInitial() - (int)$jour_demande);
        $demandeCongeRepository->find($conge_id)->setStatus(1);
        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->flush();

        return new JsonResponse([
            'status'   => 1,
            'conge_id' => $conge_id
        ]);
    }

    /**
     * @Route("/annule-conge", name="ajax_annulation_conge")
     * @param Request $request
     */
    public function annulerConge(Request $request,
                                 DemandeCongeRepository $demandeCongeRepository,
                                 MailerInterface $mailer
    )
    {
        $conge_id = $request->request->get('conge_id');
        $demandeCongeRepository->find($conge_id)->setStatus(2);
        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->flush();

        $email = (new Email())
            ->from('dtsitohina@yahoo.fr')
            ->to($demandeCongeRepository->find($conge_id)->getUser()->getEmail())
            ->subject('Demande de congé')
            ->text('Demande de congé payé')
            ->html('<p>Bonjour ' . $this->getUser()->getUsername() . ' <br> Votre demande de congé est annulé ! </p>');

        $mailer->send($email);

        return new JsonResponse([
            'status'   => 2,
            'conge_id' => $conge_id
        ]);
    }

    /**
     * @Route("/demande-conge", name="ajax_demande_conge")
     * @param Request $request
     */
    public function demandeConge(Request $request,
                                 UserRepository $userRepository,
                                 DemandeCongeRepository $demandeCongeRepository,
                                 MailerInterface $mailer)
    {
        $date_debut      = $request->request->get('date_debut');
        $modif           = $request->request->get('motif');
        $lieu_jouissance = $request->request->get('lieu_jouissance');
        $type_conge      = $request->request->get('type_conge');
        $nom_interim     = $request->request->get('nom_interim');
        $user_id         = $request->request->get('user_id');
        $nombre_jour     = $request->request->get('nombre_jour');
        $numero_demande  = $request->request->get('num_demande');

        $user = $userRepository->find($user_id);

        $jour_conge = $user && $user->getCongeInitial() ? $user->getCongeInitial() : 0;


        $nombre_jour_restant = $jour_conge - $nombre_jour;

        $date_fin = $this->getDateFin($date_debut, $nombre_jour);

        $user_has_conge = $demandeCongeRepository->findBy([
            'user'   => $user,
            'status' => 0
        ]);

        $has_conge_attente = false;
        if ($nombre_jour_restant > -1) {
            if ($user_has_conge) {
                $has_conge_attente = true;
            } else {
                $demande_conge = new DemandeConge();

                $template_send_toadmin = "
                Bonjour , <br> <br> Je tiens par la présente à vous informer de mon souhait de prendre
                des congés " . $type_conge . " pour la période allant du
                « " . (new \DateTime($date_debut))->format('d/m/Y h:i') . " » au « " . (new \DateTime($date_fin))->format('d/m/Y h:i') . " » inclus,
                 soit « " . $nombre_jour . " » jours ouvrables <br> <br> Cordialement.";

                $email_toadmin = (new Email())
                    ->from($this->getUser()->getEmail())
                    ->to('3ddy.rakoto@gmail.com')
                    ->subject('Demande de congé')
                    ->text('Demande de congé payé')
                    ->html($template_send_toadmin);

                $mailer->send($email_toadmin);

                $demande_conge->setUser($user ? $user : null);
                $demande_conge->setDateDebut(new \DateTime($date_debut));
                $demande_conge->setMotif($modif ? $modif : null);
                $demande_conge->setLieuJouissance($lieu_jouissance ? $lieu_jouissance : null);
                $demande_conge->setTypeConge($type_conge ? $type_conge : null);
                $demande_conge->setNomInterim($nom_interim ? $nom_interim : null);
                $demande_conge->setNumDemande($numero_demande);
                $demande_conge->setNombreDeJourDemande($nombre_jour);
                $demande_conge->setDateFin($date_fin);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($demande_conge);
                $entityManager->flush();

                $email = (new Email())
                    ->from('admin@codeddy.mg')
                    ->to($this->getUser()->getEmail())
                    ->subject('Demande de congé')
                    ->text('Demande de congé payé')
                    ->html('<p>Bonjour ' . $this->getUser()->getUsername() . ' <br> Votre demande de congé est en cours de validation !</p>');

                $mailer->send($email);

            }
        }

        return new JsonResponse([
            'status'              => true,
            'has_conge_attente'   => $has_conge_attente,
            'nombre_jour_restant' => $nombre_jour_restant
        ]);
    }

    protected function getDateFin($date_debut, $nombre_jour)
    {
        $month_clicke = (new \DateTime($date_debut))->format('m');
        $day_clicke   = (new \DateTime($date_debut))->format('d');
        $year_clicke  = (new \DateTime($date_debut))->format('Y');

        $jour  = (int)'';
        $mois  = (int)'';
        $annee = (int)'';

        // tester le mois
        if ($month_clicke == '02') {
            // tester l'annee
            if ($year_clicke % 4 == 0) {
                if ((int)$day_clicke + (int)$nombre_jour > 29) {
                    $jour = ((int)$day_clicke + (int)$nombre_jour) - 30;
                    if ($jour == 0) {
                        $jour  = 29;
                        $mois  = $month_clicke;
                        $annee = (int)$year_clicke;
                    } else {
                        $jour  = ((int)$day_clicke + (int)$nombre_jour) - 30;
                        $mois  = $month_clicke + 1;
                        $annee = (int)$year_clicke;
                    }

                } else {
                    $jour  = (int)$day_clicke + $nombre_jour - 1;
                    $mois  = $month_clicke;
                    $annee = (int)$year_clicke;
                }
            } else {
                if ((int)$day_clicke + (int)$nombre_jour > 28) {
                    $jour = ((int)$day_clicke + (int)$nombre_jour) - 29;
                    if ($jour == 0) {
                        $jour  = 28;
                        $mois  = $month_clicke;
                        $annee = (int)$year_clicke;
                    } else {
                        $jour  = ((int)$day_clicke + (int)$nombre_jour) - 29;
                        $mois  = $month_clicke + 1;
                        $annee = (int)$year_clicke;
                    }

                } else {
                    $jour  = (int)$day_clicke + $nombre_jour - 1;
                    $mois  = $month_clicke;
                    $annee = (int)$year_clicke;
                }
            }
        } elseif (in_array($month_clicke, ["04", "06", "09", "11"])) {
            if ((int)$day_clicke + (int)$nombre_jour > 30) {
                $jour = ((int)$day_clicke + (int)$nombre_jour) - 31;
                if ($jour == 0) {
                    $jour  = 30;
                    $mois  = $month_clicke;
                    $annee = (int)$year_clicke;
                } else {
                    $jour  = ((int)$day_clicke + (int)$nombre_jour) - 31;
                    $mois  = $month_clicke + 1;
                    $annee = (int)$year_clicke;
                }

            } else {
                $jour  = (int)$day_clicke + $nombre_jour - 1;
                $mois  = $month_clicke;
                $annee = (int)$year_clicke;
            }
        } elseif (in_array($month_clicke, ["01", "03", "05", "07", "08", "10"])) {
            if ((int)$day_clicke + (int)$nombre_jour > 31) {
                $jour = ((int)$day_clicke + (int)$nombre_jour) - 32;
                if ($jour == 0) {
                    $jour  = 31;
                    $mois  = $month_clicke;
                    $annee = (int)$year_clicke;
                } else {
                    $jour  = ((int)$day_clicke + (int)$nombre_jour) - 32;
                    $mois  = $month_clicke + 1;
                    $annee = (int)$year_clicke;
                }
            } else {
                $jour  = (int)$day_clicke + $nombre_jour - 1;
                $mois  = $month_clicke;
                $annee = (int)$year_clicke;
            }
        } else {
            if ((int)$day_clicke + (int)$nombre_jour > 31) {
                $jour = ((int)$day_clicke + (int)$nombre_jour) - 32;
                if ($jour == 0) {
                    $jour  = 31;
                    $mois  = 12;
                    $annee = (int)$year_clicke;
                } else {
                    $jour  = ((int)$day_clicke + (int)$nombre_jour) - 32;
                    $mois  = 01;
                    $annee = (int)$year_clicke + 1;
                }
            } else {
                $jour  = (int)$day_clicke + $nombre_jour - 1;
                $mois  = $month_clicke;
                $annee = (int)$year_clicke;
            }
        }

        $dat_fin = (string)($jour . '-' . $mois . '-' . $annee);

        return $dat_fin;
    }
}
