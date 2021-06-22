<?php

namespace App\Controller;

use App\Repository\DocumentRecrutementRepository;
use App\Service\Tools;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CvController
 * @package App\Controller
 */
class CvController extends AbstractController
{
    private $tools;

    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }

    /**
     * @Route("/cv-simplifie", name="cv_simplifie")
     */
    public function index(): Response
    {
        return $this->render('cv_simplifier/index.html.twig');
    }

    /**
     * @Route("/ajax-list", name="admin_cv_ajax_list")
     */
    public function ajaxList(Request $_request, DocumentRecrutementRepository $documentRecrutementRepository)
    {
        $_page        = $_request->query->get('start');
        $_nb_max_page = $_request->query->get('length');
        $_search      = $_request->query->get('search')['value'];
        $_order_by    = $_request->query->get('order_by');

        $datas = $documentRecrutementRepository->CVListArray($_page, $_nb_max_page, $_search, $_order_by);

        return new JsonResponse([
            'recordsTotal'    => $datas[1],
            'recordsFiltered' => $datas[1],
            'data'            => array_map(function ($_val) {
                return array_values($_val);
            }, $datas[0])
        ]);
    }
}
