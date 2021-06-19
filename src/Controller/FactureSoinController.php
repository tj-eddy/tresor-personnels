<?php

namespace App\Controller;

use App\Entity\FactureSoin;
use App\Form\FactureSoinType;
use App\Repository\FactureSoinRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/facture/soin")
 */
class FactureSoinController extends AbstractController
{
    /**
     * @Route("/", name="facture_soin_index", methods={"GET"})
     */
    public function index(FactureSoinRepository $factureSoinRepository): Response
    {
        return $this->render('facture_soin/index.html.twig', [
            'facture_soins' => $factureSoinRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="facture_soin_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserRepository $userRepository): Response
    {
        if ($this->isGranted('ROLE_SUPERADMIN')) {
            return $this->redirectToRoute('facture_soin_index');
        }
        $factureSoin = new FactureSoin();
        $form        = $this->createForm(FactureSoinType::class, $factureSoin);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $user = $userRepository->find($request->request->get('user_id'));
            $factureSoin->setUser($user);
            $factureSoin->setStatus(0);
            $entityManager->persist($factureSoin);
            $entityManager->flush();

            return $this->redirectToRoute('facture_soin_index');
        }

        return $this->render('facture_soin/new.html.twig', [
            'facture_soin' => $factureSoin,
            'form'         => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="facture_soin_show", methods={"GET"})
     */
    public function show(FactureSoin $factureSoin): Response
    {
        return $this->render('facture_soin/show.html.twig', [
            'facture_soin' => $factureSoin,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="facture_soin_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, FactureSoin $factureSoin): Response
    {
        $form = $this->createForm(FactureSoinType::class, $factureSoin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('facture_soin_index');
        }

        return $this->render('facture_soin/edit.html.twig', [
            'facture_soin' => $factureSoin,
            'form'         => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="facture_soin_delete", methods={"DELETE"})
     */
    public function delete(Request $request, FactureSoin $factureSoin): Response
    {
        if ($this->isCsrfTokenValid('delete' . $factureSoin->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($factureSoin);
            $entityManager->flush();
        }

        return $this->redirectToRoute('facture_soin_index');
    }

    /**
     * @Route("/{id}/valide", name="facture_soin_valide")
     * @param $id_fact
     */
    public function validerFactureSoin(FactureSoin $factureSoin)
    {
        if ($factureSoin) {
            $factureSoin->setStatus(1);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

        }
        return $this->redirectToRoute('facture_soin_index');

    }
}
