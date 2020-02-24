<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\Term;
use App\Form\CourseType;
use App\Repository\CourseRepository;
use App\Entity\Description;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/course")
 */
class CourseController extends Controller
{
    /**
     * @Route("/", name="course_index", methods={"GET"})
     */
    public function index(CourseRepository $courseRepository): Response
    {
        return $this->render('course/index.html.twig', [
            'courses' => $courseRepository->findAllAsc(),
        ]);
    }

    /**
     * @Route("/area/{term}/{area}", name="course_area", methods={"GET"}, defaults={"term"="current","area"="U"})
     */
    public function area(CourseRepository $courseRepository, $area, $term): Response
    {
        $terms = $this->getDoctrine()
            ->getRepository(Term::class)->findCurrent();
        if ($term =='current') {
            $term = $this->getDoctrine()
                ->getRepository(Term::class)->findDefault();
            $term = $term->getTerm();
        }
        $termname = $this->getDoctrine()
            ->getRepository(Term::class)->findName($term);
        return $this->render('course/index.html.twig', [
            'courses' => $courseRepository->findByArea($area, $term),
            'terms' => $terms,
            'termname' => $termname
        ]);
    }

    /**
     * @Route("/upper/{term}/{area}", name="course_upper", methods={"GET"}, defaults={"term"="current","area"="U"})
     */
    public function upper(CourseRepository $courseRepository, $area, $term): Response
    {
        $terms = $this->getDoctrine()
            ->getRepository(Term::class)->findCurrent();
        if ($term =='current') {
            $term = $this->getDoctrine()
                ->getRepository(Term::class)->findDefault();
            $term = $term->getTerm();
        }
        $termname = $this->getDoctrine()
            ->getRepository(Term::class)->findName($term);
        return $this->render('course/area.html.twig', [
            'courses' => $courseRepository->findByArea($area, $term),
            'terms' => $terms,
            'termname' => $termname
        ]);
    }

    /**
     * @Route("/user", name="course_user", methods={"GET"})
     */
    public function byuser(CourseRepository $courseRepository): Response
    {
        $terms = $this->getDoctrine()
            ->getRepository(Term::class)->findCurrent();

        $user = $this->getUser();
        $name = $user->getLastname().', '.$user->getFirstname();
        return $this->render('course/index.html.twig', [
            'courses' => $courseRepository->findByName($name),
            'terms' => $terms
        ]);
    }

    /**
     * @Route("/new", name="course_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $course = new Course();
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($course);
            $entityManager->flush();

            return $this->redirectToRoute('course_index');
        }

        return $this->render('course/new.html.twig', [
            'course' => $course,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="course_show", methods={"GET"})
     */
    public function show(Course $course): Response
    {
        $name = 'none';
        if ($this->get('security.authorization_checker')->isGranted('ROLE_EDITOR')) {
            $user = $this->getUser();
            $name = $user->getLastname().', '.$user->getFirstname();
        }
        $termname = $this->getDoctrine()
            ->getRepository(Term::class)->findName($course->getTerm());
        $terms = $this->getDoctrine()
            ->getRepository(Term::class)->findCurrent();
        $descriptions = $this->getDoctrine()
            ->getRepository(Description::class)->findByTermcall($course->getTermcall());
        return $this->render('course/show.html.twig', [
            'descriptions' => $descriptions,
            'course' => $course,
            'terms' => $terms,
            'termname' => $termname,
            'name' => $name
        ]);
    }

    /**
     * @Route("/{id}/edit", name="course_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Course $course): Response
    {
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('course_show', ['id' => $course->getId()]);
        }

        return $this->render('course/edit.html.twig', [
            'course' => $course,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="course_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Course $course): Response
    {
        if ($this->isCsrfTokenValid('delete'.$course->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($course);
            $entityManager->flush();
        }

        return $this->redirectToRoute('course_index');
    }
}
