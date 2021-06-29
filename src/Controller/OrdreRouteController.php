<?php

namespace App\Controller;

use App\Entity\OrdreRoute;
use App\Form\OrdreRouteType;
use App\Repository\OrdreRouteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/ordre/route")
 */
class OrdreRouteController extends AbstractController
{
    /**
     * @Route("/", name="ordre_route_index", methods={"GET"})
     */
    public function index(OrdreRouteRepository $ordreRouteRepository, Security $security): Response
    {
        $ordre_routes = $ordreRouteRepository->findBy([
            'user' => $this->getUser()
        ]);

        $_is_admin = in_array('ROLE_SUPERADMIN', $security->getUser()->getRoles());
        return $this->render('ordre_route/index.html.twig', [
            'ordre_routes' => $_is_admin ? $ordreRouteRepository->findBy([], ['id' => 'DESC']) : $ordre_routes,
        ]);
    }

    /**
     * @Route("/new", name="ordre_route_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $datas         = $request->request->all();
        $ordreRoute = new OrdreRoute();
        $form       = $this->createForm(OrdreRouteType::class, $ordreRoute);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $ordreRoute->setUser($this->getUser());

            $ordreRoute->setDureeMission($datas["duree_mission"] ? $datas["duree_mission"] : null);
            $ordreRoute->setDecompteOr($datas["decompte_or"] ? $datas["decompte_or"] : null);
            $entityManager->persist($ordreRoute);
            $entityManager->flush();

            return $this->redirectToRoute('ordre_route_index');
        }

        return $this->render('ordre_route/new.html.twig', [
            'ordre_route' => $ordreRoute,
            'type'        => 'new_or',
            'form'        => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ordre_route_show", methods={"GET"})
     */
    public function show(OrdreRoute $ordreRoute): Response
    {
        return $this->render('ordre_route/show.html.twig', [
            'ordre_route' => $ordreRoute,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ordre_route_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, OrdreRoute $ordreRoute): Response
    {
        $form = $this->createForm(OrdreRouteType::class, $ordreRoute);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $datas         = $request->request->all();
            $ordreRoute->setDureeMission($datas["duree_mission"] ? $datas["duree_mission"] : null);
            $ordreRoute->setDecompteOr($datas["decompte_or"] ? $datas["decompte_or"] : null);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ordre_route_index');
        }

        return $this->render('ordre_route/edit.html.twig', [
            'ordre_route' => $ordreRoute,
            'type'        => 'edit_or',
            'form'        => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ordre_route_delete", methods={"DELETE"})
     */
    public function delete(Request $request, OrdreRoute $ordreRoute): Response
    {
        if ($this->isCsrfTokenValid('delete' . $ordreRoute->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ordreRoute);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ordre_route_index');
    }
    /**
     * @Route("/{id}/validate-or", name="ordre_route_validate")
     */
    public function validateOR(OrdreRoute $ordreRoute)
    {
        if($ordreRoute){
            $entityManager = $this->getDoctrine()->getManager();
            $ordreRoute->setStatus(true);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ordre_route_index');
    }
}
