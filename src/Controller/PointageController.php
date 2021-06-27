<?php

namespace App\Controller;

use App\Entity\Pointage;
use App\Repository\PointageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/pointage")
 */
class PointageController extends AbstractController
{
    /**
     * @Route("/", name="pointage_index", methods={"GET"})
     */
    public function index(PointageRepository $pointageRepository): Response
    {
        $ptg_exist = $pointageRepository->findOneBy([
            'id' => $pointageRepository->getMaxIdPtg($this->getUser()->getId())
        ]);

        return $this->render('pointage/index.html.twig', [
            'pointages' => $pointageRepository->findAll(),
            'has_hsa'   => $ptg_exist && $ptg_exist->getHeureSortieAp() ? 1 : 0
        ]);
    }

    /**
     * @Route("/ajax-list", name="url_pointage_ajax_list")
     */
    public function ajaxList(Request $_request, PointageRepository $pointageRepository)
    {
        $_page        = $_request->query->get('start');
        $_nb_max_page = $_request->query->get('length');
        $_search      = $_request->query->get('search')['value'];
        $_order_by    = $_request->query->get('order_by');

        $datas = $pointageRepository->pointageListArray($_page, $_nb_max_page, $_search, $_order_by);

        return new JsonResponse([
            'recordsTotal'    => $datas[1],
            'recordsFiltered' => $datas[1],
            'data'            => array_map(function ($_val) {
                return array_values($_val);
            }, $datas[0])
        ]);
    }

    /**
     * @Route("/pointage", name="url_pointage")
     */
    public function pointage(Request $request, PointageRepository $pointageRepository)
    {
        $status   = false;
        $data     = $request->request->all();
        $em       = $this->getDoctrine()->getManager();
        $pointage = new Pointage();
        if ($data['ham'] !== "") {
            $pointage->setUser($this->getUser());
            $pointage->setDateArriveMatinee(new \DateTime());
            $status = true;
            $em->persist($pointage);
        } elseif ($data['hsm'] !== "" && $data['ham'] === "") {
            $ptg_exist = $pointageRepository->findOneBy([
                'id' => $pointageRepository->getMaxIdPtg($this->getUser()->getId())
            ]);
            $status    = true;
            $ptg_exist->setHeureSortieMatinee(new \DateTime());
        } elseif ($data['haa'] !== "" && $data['ham'] === "" && $data['hsm'] === "") {
            $ptg_exist = $pointageRepository->findOneBy([
                'id' => $pointageRepository->getMaxIdPtg($this->getUser()->getId())
            ]);
            $status    = true;
            $ptg_exist->setHeureArriveeAp(new \DateTime());
        } elseif ($data['hsa'] !== "" && $data['ham'] === "" && $data['hsm'] === "" && $data['haa'] === "") {
            $ptg_exist = $pointageRepository->findOneBy([
                'id' => $pointageRepository->getMaxIdPtg($this->getUser()->getId())
            ]);
            $status    = true;
            $ptg_exist->setHeureSortieAp(new \DateTime());
        }
        $em->flush();
        return new JsonResponse([
            'status' => $status
        ]);
    }
}
