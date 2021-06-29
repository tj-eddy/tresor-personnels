<?php

namespace App\Controller;

use App\Entity\OrdreRoute;
use App\Entity\User;
use App\Form\OrdreRouteType;
use App\Repository\DocumentRecrutementRepository;
use App\Repository\OrdreRouteRepository;
use App\Service\ChiffresEnLettres;
use Dompdf\Dompdf;
use Dompdf\Options;
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
    private $conversion_chiffre_lettre;

    public function __construct(ChiffresEnLettres $chiffreEnLettre)
    {
        $this->conversion_chiffre_lettre = $chiffreEnLettre;
    }

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
        $datas      = $request->request->all();
        $ordreRoute = new OrdreRoute();
        $form       = $this->createForm(OrdreRouteType::class, $ordreRoute);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $ordreRoute->setUser($this->getUser());

            $ordreRoute->setDureeMission($datas["duree_mission"] ? $datas["duree_mission"] : null);
            $ordreRoute->setDecompteOr($datas["decompte_or"] ? $datas["decompte_or"] : null);
            $ordreRoute->setMontantN($datas["montant_n"] ? $datas["montant_n"] : null);
            $ordreRoute->setMontantP($datas["montant_p"] ? $datas["montant_p"] : null);

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
     * @Route("/{id}/voir-tout", name="ordre_route_showall", methods={"GET"})
     */
    public function showAll(OrdreRouteRepository $ordreRouteRepository): Response
    {
        return $this->render('ordre_route/showall.html.twig', [
            'ordre_routes' => $ordreRouteRepository->findBy(['user' => $this->getUser()]),
            'template_pdf' => false,
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
            $datas = $request->request->all();
            $ordreRoute->setDureeMission($datas["duree_mission"] ? $datas["duree_mission"] : null);
            $ordreRoute->setDecompteOr($datas["decompte_or"] ? $datas["decompte_or"] : null);
            $ordreRoute->setMontantN($datas["montant_n"] ? $datas["montant_n"] : null);
            $ordreRoute->setMontantP($datas["montant_p"] ? $datas["montant_p"] : null);

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
        if ($ordreRoute) {
            $entityManager = $this->getDoctrine()->getManager();
            $ordreRoute->setStatus(true);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ordre_route_index');
    }

    /**
     * @Route("/{id}/generate-or", name="generate_or_pdf")
     */
    public function generateORPdf(OrdreRouteRepository $ordreRouteRepository,
                                  User $user,
                                  DocumentRecrutementRepository $documentRecrutementRepository
    )
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($pdfOptions);

        $html = $this->renderView('ordre_route/template_or.html.twig', [
            'ordre_routes'         => $ordreRouteRepository->findBy(['user' => $user]),
            'template_pdf'         => true,
            'montant_total_lettre' => $this->conversion_chiffre_lettre->Conversion($ordreRouteRepository->getSumDecompteOR($user->getId())),
            'document_recrutement' => $documentRecrutementRepository->findOneBy(['user' => $user])
        ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        ob_end_clean();
        $dompdf->stream("ordre_de_route.pdf", [
            "Attachment" => true
        ]);

        return new Response('', 200, [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
