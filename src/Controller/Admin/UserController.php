<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/admin/user")
 */
class UserController extends AbstractController
{
    private $translator;
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @IsGranted("ROLE_SUPERADMIN")
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('admin/user/index.html.twig', [
            'path_uploaded' => $this->getParameter('upload_dir_profil')
        ]);
    }

    /**
     * @Route("/ajax-list", name="admin_user_ajax_list")
     */
    public function ajaxList(Request $_request, UserRepository $userRepository)
    {
        $_page        = $_request->query->get('start');
        $_nb_max_page = $_request->query->get('length');
        $_search      = $_request->query->get('search')['value'];
        $_order_by    = $_request->query->get('order_by');

        $datas = $userRepository->userListArray($_page, $_nb_max_page, $_search, $_order_by);

        return new JsonResponse([
            'recordsTotal'    => $datas[1],
            'recordsFiltered' => $datas[1],
            'data'            => array_map(function ($_val) {
                return array_values($_val);
            }, $datas[0])
        ]);
    }

    /**
     * @IsGranted("ROLE_SUPERADMIN")
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request, SluggerInterface $slugger): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $picture = $form->get('profil')->getData();
            if ($picture) {
                $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename     = $slugger->slug($originalFilename);
                $newFilename      = $safeFilename . '-' . uniqid() . '.' . $picture->guessExtension();
                try {
                    $picture->move(
                        $this->getParameter('upload_dir_profil'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    print($e);
                }

                $user->setProfil($newFilename);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $user->setPassword(password_hash('123456789', 'argon2i'));
            $user->setRoles(["ROLE_EMPLOYE"]);
            $user->setDateStartService(new \DateTime());
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', $this->translator->trans('add.succesfully'));

            return $this->redirectToRoute('user_index');
        }

        return $this->render('admin/user/new.html.twig', [
            'user'        => $user,
            'form'        => $form->createView(),
            'action_type' => 'new',
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $picture = $form->get('profil')->getData();
            if ($picture) {
                $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename     = $slugger->slug($originalFilename);
                $newFilename      = $safeFilename . '-' . uniqid() . '.' . $picture->guessExtension();
                try {
                    $picture->move(
                        $this->getParameter('upload_dir_profil'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    print($e);
                }

                $user->setProfil($newFilename);
            }
            if (!in_array('ROLE_SUPERADMIN', $user->getRoles())) {
                $user->setPassword($user->getPassword());
            } else {
                $user->setPassword(password_hash($form->get('password')->getData(), 'argon2i'));
            }
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', $this->translator->trans('update.succesfully'));

            return $this->redirectToRoute('admin_dashboard');
        }

        return $this->render('admin/user/edit.html.twig', [
            'user'        => $user,
            'form'        => $form->createView(),
            'action_type' => 'edit',
        ]);
    }

    /**
     * @Route("/{id}/delete", name="user_delete")
     */
    public function delete(User $user)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user->setIsDeleted(true);
        $user->setEmail($user->getEmail() . ".deleted");
        $entityManager->flush();

        $this->addFlash('success', $this->translator->trans('delete.succesfully'));

        return $this->redirectToRoute('user_index');
    }

    /**
     * @Route("/user-ajax-select2", name="admin_user_ajax_select2")
     */
    public function userAjaxSelect2(Request $_request, UserRepository $userRepository)
    {
        $t = $_request->query->get('search');

        $term = $userRepository->userSelectArray($t);

        return new JsonResponse($term);
    }
}