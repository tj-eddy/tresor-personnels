<?php

namespace App\Controller;

use App\Entity\DocumentRecrutement;
use App\Entity\User;
use App\Form\DocumentRecrutementType;
use App\Repository\DocumentRecrutementRepository;
use App\Repository\UserRepository;
use http\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

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
    public function new(Request $request,
                        DocumentRecrutementRepository $documentRecrutementRepository,
                        UserRepository $userRepository, SluggerInterface $slugger): Response
    {
        $documentRecrutement = new DocumentRecrutement();
        $form                = $this->createForm(DocumentRecrutementType::class, $documentRecrutement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user_id = $request->request->get('user_id');
            $user    = $userRepository->find($user_id);
            $documentRecrutement->setUser($user);
            $entityManager = $this->getDoctrine()->getManager();
            $documentRecrutementRepository->ScanDocument($form, $slugger, $documentRecrutement, $this->getParameter('upload_scan_doc'));
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
    public function edit(SluggerInterface $slugger,
                         DocumentRecrutementRepository $documentRecrutementRepository,
                         Request $request, UserRepository $userRepository,
                         DocumentRecrutement $documentRecrutement): Response
    {
        $form = $this->createForm(DocumentRecrutementType::class, $documentRecrutement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user_id = $request->request->get('user_id');
            $user    = $userRepository->find($user_id);
            $documentRecrutement->setUser($user);
            $documentRecrutementRepository->ScanDocument($form, $slugger, $documentRecrutement, $this->getParameter('upload_scan_doc'));
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

    /**
     * @Route("/{id}/download", name="download_doc_file")
     */
    public function downloadFileAction(DocumentRecrutement $documentRecrutement,
                                       DocumentRecrutementRepository $documentRecrutementRepository)
    {
        try {
            $file = $documentRecrutementRepository->find($documentRecrutement->getId());
            if (!$file) {
                $array    = array(
                    'status'  => 0,
                    'message' => 'File does not exist'
                );
                $response = new JsonResponse ($array, 200);
                return $response;
            }
            $displayName    = $file->getScanDoc();
            $fileName       = $file->getScanDoc();
            $file_with_path = $this->getParameter('upload_scan_doc') . "/" . $fileName;
            $response       = new BinaryFileResponse ($file_with_path);
            $response->headers->set('Content-Type', 'text/plain');
            $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $displayName);
            return $response;
        } catch (Exception $e) {
            $array    = array(
                'status'  => 0,
                'message' => 'Download error'
            );
            $response = new JsonResponse ($array, 400);
            return $response;
        }
    }
}
