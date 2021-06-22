<?php

namespace App\Controller;

use App\Entity\Attribution;
use App\Form\AttributionType;
use App\Repository\AttributionRepository;
use App\Repository\UserRepository;
use App\Service\Tools;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/attribution")
 */
class AttributionController extends AbstractController
{
    private $translator;
    private $tools;

    /**
     * UserController constructor.
     * @param TranslatorInterface $translator
     * @param Tools $tools
     */
    public function __construct(TranslatorInterface $translator, Tools $tools)
    {
        $this->translator = $translator;
        $this->tools      = $tools;
    }

    /**
     * @Route("/", name="attribution_index", methods={"GET"})
     */
    public function index(Request $request): Response
    {
        return $this->render('attribution/index.html.twig');
    }

    /**
     * @Route("/ajax-list", name="admin_attribution_ajax_list")
     */
    public function ajaxList(Request $_request, AttributionRepository $attributionRepository)
    {
        $_page        = $_request->query->get('start');
        $_nb_max_page = $_request->query->get('length');
        $_search      = $_request->query->get('search')['value'];
        $_order_by    = $_request->query->get('order_by');

        $datas = $attributionRepository->attributionListArray($_page, $_nb_max_page, $_search, $_order_by);

        return new JsonResponse([
            'recordsTotal'    => $datas[1],
            'recordsFiltered' => $datas[1],
            'data'            => array_map(function ($_val) {
                return array_values($_val);
            }, $datas[0])
        ]);
    }

    /**
     * @Route("/new", name="attribution_new", methods={"GET","POST"})
     */
    public function new(Request $request,
                        UserRepository $userRepository,
                        AttributionRepository $attributionRepository
    ): Response
    {
        if (!$this->isGranted('ROLE_SUPERADMIN')) {
            return $this->redirectToRoute('attribution_index');
        }

        $attribution = new Attribution();
        $form        = $this->createForm(AttributionType::class, $attribution);
        $form->handleRequest($request);

        $entityManager = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid()) {
            $user   = $userRepository->find($request->request->get('user_id'));
            $tasks  = $request->request->get('task_selected')[0];
            $taches = explode(',', $tasks);

            foreach ($taches as $k => $v) {
                $count_user_task = $attributionRepository->findBy([
                    'user'   => $user,
                    'status' => false
                ]);

                if (count($count_user_task) < 4) {
                    // etat attribution avant attribution
                    $attr_avant = $attributionRepository->findOneBy([
                        'nom_tache' => $v,
                        'status'    => false
                    ]);
                    if ($attr_avant) {
                        $attr_avant->setDateFin(new \DateTime());
                        $attr_avant->setStatus(true);
                        $entityManager->persist($attr_avant);
                        $entityManager->flush();
                    }

                    $attribution = new Attribution();
                    $attribution->setUser($user);
                    $attribution->setNumeroTache('#' .$attributionRepository->generateIdTask());
                    $attribution->setDateDebut(new \DateTime());
                    $attribution->setStatus(0);
                    $attribution->setNomTache($v);
                    $entityManager->persist($attribution);
                    $entityManager->flush();
                } else {
                    $this->addFlash('danger', $this->translator->trans('Cet employé a déjà 4 tache en cours !'));
                    return $this->redirectToRoute('attribution_index');
                }
            }

            return $this->redirectToRoute('attribution_index');
        }

        return $this->render('attribution/new.html.twig', [
            'attribution' => $attribution,
            'form'        => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="attribution_show", methods={"GET"})
     */
    public function show(Attribution $attribution): Response
    {
        return $this->render('attribution/show.html.twig', [
            'attribution' => $attribution,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="attribution_edit", methods={"GET","POST"})
     */
    public function edit(Request $request,
                         Attribution $attribution,
                         AttributionRepository $attributionRepository,
                         UserRepository $userRepository): Response
    {
        $form = $this->createForm(AttributionType::class, $attribution);
        $form->handleRequest($request);
        $entityManager = $this->getDoctrine()->getManager();
        $attr_apres    = new Attribution();
        if ($form->isSubmitted() && $form->isValid()) {
            $user_to_attribute = $userRepository->find($request->request->get('user_id'));
            $user_current      = $attribution->getUser();
            if ($user_current) {
                // etat attribution avant attribution
                $attr_avant = $attributionRepository->findOneBy([
                    'user' => $user_current,
                    'id'   => $attribution->getId()
                ]);
                $attr_avant->setDateFin(new \DateTime());
                $attr_avant->setStatus(true);
                $entityManager->persist($attr_avant);

                // etat attribution apres attribution
                $count_user_task = $attributionRepository->findBy([
                    'user'   => $user_to_attribute,
                    'status' => 0
                ]);

                if ($attr_apres && count($count_user_task) < 4) {
                    $attr_apres->setDateDebut(new \DateTime());
                    $attr_apres->setDateFin(null);
                    $attr_apres->setStatus(false);
                    $attr_apres->setNomTache($attr_avant->getNomTache());
                    $attr_apres->setUser($user_to_attribute);
                    $attr_apres->setNumeroTache($attr_avant->getNumeroTache());
                    $entityManager->persist($attr_apres);
                } else {
                    $this->addFlash('danger', $this->translator->trans('Cet employé a déjà 4 tache en cours'));
                    return $this->redirectToRoute('attribution_index');
                }

                $entityManager->flush();
            }

            return $this->redirectToRoute('attribution_index');
        }

        return $this->render('attribution/edit.html.twig', [
            'attribution' => $attribution,
            'form'        => $form->createView(),
        ]);
    }


    /**
     * @Route("/delete/{id}", name="attribution_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Attribution $attribution): Response
    {
        if ($this->isCsrfTokenValid('delete' . $attribution->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($attribution);
            $entityManager->flush();
        }

        return $this->redirectToRoute('attribution_index');
    }

}
