<?php

namespace App\Controller;

use App\Entity\Attribution;
use App\Form\AttributionType;
use App\Repository\AttributionRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/attribution")
 */
class AttributionController extends AbstractController
{
    /**
     * @Route("/", name="attribution_index", methods={"GET"})
     */
    public function index(AttributionRepository $attributionRepository): Response
    {
        return $this->render('attribution/index.html.twig', [
            'attributions' => $attributionRepository->findAll(),
        ]);
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
    public function new(Request $request, UserRepository $userRepository): Response
    {
        $attribution = new Attribution();
        $form        = $this->createForm(AttributionType::class, $attribution);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $userRepository->find($request->request->get('user_id'));
            $attribution->setUser($user);
            $attribution->setNumeroTache('Tache n°:' . $user->getId());
            $attribution->setDateDebut(new \DateTime());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($attribution);
            $entityManager->flush();

            return $this->redirectToRoute('attribution_index');
        }

        return $this->render('attribution/new.html.twig', [
            'attribution' => $attribution,
            'form'        => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="attribution_show", methods={"GET"})
     */
    public function show(Attribution $attribution): Response
    {
        return $this->render('attribution/show.html.twig', [
            'attribution' => $attribution,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="attribution_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Attribution $attribution): Response
    {
        $form = $this->createForm(AttributionType::class, $attribution);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('attribution_index');
        }

        return $this->render('attribution/edit.html.twig', [
            'attribution' => $attribution,
            'form'        => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="attribution_delete", methods={"DELETE"})
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

    /**
     * @Route("/change-attribution", name="change_attribution_ajax")
     */
    public function changeAttribution(Request $request,
                                      UserRepository $userRepository,
                                      AttributionRepository $attributionRepository
    )
    {
        $new_id  = $request->request->get('nouveau_employe');
        $old_id  = $request->request->get('old_employe');
        $attr_id = $request->request->get('id_attribution');

        $user_old = $userRepository->find($old_id);
        $user_old->setStatusTache(1);
        $user_new = $userRepository->find($new_id);
        $user_new->setStatusTache(0);
        $attr = $attributionRepository->find($attr_id);
        if ($attr) {
            $attr->setUser($user_new);
            $attributionRepository->updateStatusAttribution($user_new, $attr_id, $user_old);
        }
        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->flush();

        return new JsonResponse([
            'status' => true,
        ]);
    }
}
