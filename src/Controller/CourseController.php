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
     * @Route("/area/{term}/{area}", name="course_area", methods={"GET"})
     */
    public function area(CourseRepository $courseRepository, $area, $term): Response
    {
        if ($term =='current') {
            $term = $this->getDoctrine()
                ->getRepository(Term::class)->findDefault();
            $term = $term->getTerm();
        }
        return $this->render('course/index.html.twig', [
            'courses' => $courseRepository->findByArea($area, $term),
        ]);
    }

    /**
     * @Route("/user", name="course_user", methods={"GET"})
     */
    public function byuser(CourseRepository $courseRepository): Response
    {
        $user = $this->getUser();
        $name = $user->getLastname().', '.$user->getFirstname();
        return $this->render('course/index.html.twig', [
            'courses' => $courseRepository->findByName($name),
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
        $descriptions = $this->getDoctrine()
            ->getRepository(Description::class)->findByTermcall($course->getTermcall());
        return $this->render('course/show.html.twig', [
            'descriptions' => $descriptions,
            'course' => $course,
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

            return $this->redirectToRoute('course_index');
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
