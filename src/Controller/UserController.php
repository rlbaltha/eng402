<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\Term;
use App\Entity\User;
use App\Form\UserType;
use App\Form\AdminUserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $terms = $this->getDoctrine()
            ->getRepository(Term::class)->findCurrent();
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
            'terms' => $terms
        ]);
    }

//    /**
//     * @Route("/new", name="user_new", methods={"GET","POST"})
//     */
//    public function new(Request $request): Response
//    {
////        $this->denyAccessUnlessGranted('ROLE_ADMIN');
//        $user = new User();
//        $form = $this->createForm(UserType::class, $user);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $entityManager = $this->getDoctrine()->getManager();
//            $entityManager->persist($user);
//            $entityManager->flush();
//
//            return $this->redirectToRoute('user_index');
//        }
//
//        return $this->render('user/new.html.twig', [
//            'user' => $user,
//            'form' => $form->createView(),
//        ]);
//    }

    /**
     * @Route("/home", name="user_home", methods={"GET"})
     */
    public function home(): Response
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $user = $this->getUser();

        if ($user->getLastname() == '') {
            return $this->redirectToRoute('user_edit', ['id' => $user->getId()]);
        }
        $name = $user->getLastname().', '.$user->getFirstname();
        $courses = $this->getDoctrine()
            ->getRepository(Course::class)->findByName($name);
        $terms = $this->getDoctrine()
            ->getRepository(Term::class)->findCurrent();
        return $this->render('user/home.html.twig', [
            'user' => $user,
            'courses' => $courses,
            'terms' => $terms
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $terms = $this->getDoctrine()
            ->getRepository(Term::class)->findCurrent();
        return $this->render('user/show.html.twig', [
            'user' => $user,
            'terms' => $terms
        ]);
    }

    /**
     * @Route("/{id}/admin_edit", name="user_admin_edit", methods={"GET","POST"})
     */
    public function admin_edit(Request $request, User $user): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $form = $this->createForm(AdminUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_home');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }
}
