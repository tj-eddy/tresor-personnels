<?php

namespace App\Controller;

use App\Entity\DocumentRecrutement;
use App\Entity\User;
use App\Form\DocumentRecrutementType;
use App\Repository\DocumentRecrutementRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/document/recrutement")
 */
class DocumentRecrutementController extends AbstractController
{
    /**
     * @Route("/", name="document_recrutement_index", methods={"GET"})
     */
    public function index(DocumentRecrutementRepository $documentRecrutementRepository): Response
    {
        return $this->render('document_recrutement/index.html.twig');
    }

    /**
     * @Route("/ajax-list", name="admin_document_recrutement_ajax_list")
     */
    public function ajaxList(Request $_request, DocumentRecrutementRepository $documentRecrutementRepository)
    {
        $_page        = $_request->query->get('start');
        $_nb_max_page = $_request->query->get('length');
        $_search      = $_request->query->get('search')['value'];
        $_order_by    = $_request->query->get('order_by');

        $datas = $documentRecrutementRepository->documentRecrutementListArray($_page, $_nb_max_page, $_search, $_order_by);

        return new JsonResponse([
            'recordsTotal'    => $datas[1],
            'recordsFiltered' => $datas[1],
            'data'            => array_map(function ($_val) {
                return array_values($_val);
            }, $datas[0])
        ]);
    }

    /**
     * @Route("/new", name="document_recrutement_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserRepository $userRepository): Response
    {
        $documentRecrutement = new DocumentRecrutement();
        $form                = $this->createForm(DocumentRecrutementType::class, $documentRecrutement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user_id = $request->request->get('user_id');
            $user    = $userRepository->find($user_id);
            $documentRecrutement->setUser($user);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($documentRecrutement);
            $entityManager->flush();

            return $this->redirectToRoute('document_recrutement_index');
        }

        return $this->render('document_recrutement/new.html.twig', [
            'document_recrutement' => $documentRecrutement,
            'form'                 => $form->createView(),
            'action_type'          => 'new',
        ]);
    }

    /**
     * @Route("/{id}", name="document_recrutement_show", methods={"GET"})
     */
    public function show(DocumentRecrutement $documentRecrutement): Response
    {
        return $this->render('document_recrutement/show.html.twig', [
            'document_recrutement' => $documentRecrutement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="document_recrutement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, UserRepository $userRepository, DocumentRecrutement $documentRecrutement): Response
    {
        $form = $this->createForm(DocumentRecrutementType::class, $documentRecrutement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user_id = $request->request->get('user_id');
            $user    = $userRepository->find($user_id);
            $documentRecrutement->setUser($user);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('document_recrutement_index');
        }

        return $this->render('document_recrutement/edit.html.twig', [
            'document_recrutement' => $documentRecrutement,
            'form'                 => $form->createView(),
            'action_type'          => 'update',
        ]);
    }

    /**
     * @Route("/{id}", name="document_recrutement_delete", methods={"DELETE"})
     */
    public function delete(Request $request, DocumentRecrutement $documentRecrutement): Response
    {
        if ($this->isCsrfTokenValid('delete' . $documentRecrutement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($documentRecrutement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('document_recrutement_index');
    }
}
