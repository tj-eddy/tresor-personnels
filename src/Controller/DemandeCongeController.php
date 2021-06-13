<?php

namespace App\Controller;

use App\Entity\DemandeConge;
use App\Form\DemandeCongeType;
use App\Repository\DemandeCongeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    public function new(Request $request): Response
    {
        $demandeConge = new DemandeConge();
        $form = $this->createForm(DemandeCongeType::class, $demandeConge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($demandeConge);
            $entityManager->flush();

            return $this->redirectToRoute('demande_conge_index');
        }

        return $this->render('demande_conge/new.html.twig', [
            'demande_conge' => $demandeConge,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="demande_conge_show", methods={"GET"})
     */
    public function show(DemandeConge $demandeConge): Response
    {
        return $this->render('demande_conge/show.html.twig', [
            'demande_conge' => $demandeConge,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="demande_conge_edit", methods={"GET","POST"})
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
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="demande_conge_delete", methods={"DELETE"})
     */
    public function delete(Request $request, DemandeConge $demandeConge): Response
    {
        if ($this->isCsrfTokenValid('delete'.$demandeConge->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($demandeConge);
            $entityManager->flush();
        }

        return $this->redirectToRoute('demande_conge_index');
    }
}
