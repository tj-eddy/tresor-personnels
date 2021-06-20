<?php

namespace App\Controller;

use App\Entity\Diplome;
use App\Entity\User;
use App\Form\DiplomeType;
use App\Repository\DiplomeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/diplome")
 */
class DiplomeController extends AbstractController
{
    /**
     * @Route("/", name="diplome_index", methods={"GET"})
     */
    public function index(DiplomeRepository $diplomeRepository, Security $security): Response
    {
        $diplome   = $diplomeRepository->findBy([
            'user' => $this->getUser()
        ]);
        $_is_admin = in_array('ROLE_SUPERADMIN', $security->getUser()->getRoles());
        return $this->render('diplome/index.html.twig', [
            'diplomes' => $_is_admin ? $diplomeRepository->findAll() : $diplome,
        ]);
    }

    /**
     * @Route("/show-diplome/{id}", name="diplome_list", methods={"GET"})
     * @param DiplomeRepository $diplomeRepository
     * @param User $user
     * @return Response
     */
    public function voirDiplome(DiplomeRepository $diplomeRepository, User $user): Response
    {
        $diplome   = $diplomeRepository->findBy([
            'user' => $user
        ]);
        return $this->render('diplome/index.html.twig', [
            'diplomes' =>  $diplome,
        ]);
    }

    /**
     * @Route("/new", name="diplome_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        if ($this->isGranted('ROLE_SUPERADMIN')) {
            return $this->redirectToRoute('diplome_index');
        }
        $diplome = new Diplome();
        $form    = $this->createForm(DiplomeType::class, $diplome);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $diplome->setUser($this->getUser());
            $diplome->setScan('scan');
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($diplome);
            $entityManager->flush();

            return $this->redirectToRoute('diplome_index');
        }

        return $this->render('diplome/new.html.twig', [
            'diplome' => $diplome,
            'form'    => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="diplome_show", methods={"GET"})
     */
    public function show(Diplome $diplome): Response
    {
        return $this->render('diplome/show.html.twig', [
            'diplome' => $diplome,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="diplome_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Diplome $diplome): Response
    {
        $form = $this->createForm(DiplomeType::class, $diplome);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('diplome_index');
        }

        return $this->render('diplome/edit.html.twig', [
            'diplome' => $diplome,
            'form'    => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="diplome_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Diplome $diplome): Response
    {
        if ($this->isCsrfTokenValid('delete' . $diplome->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($diplome);
            $entityManager->flush();
        }

        return $this->redirectToRoute('diplome_index');
    }
}
