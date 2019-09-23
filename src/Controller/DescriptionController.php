<?php

namespace App\Controller;

use App\Entity\Description;
use App\Entity\Course;
use App\Form\DescriptionType;
use App\Repository\DescriptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/description")
 */
class DescriptionController extends Controller
{
    /**
     * @Route("/", name="description_index", methods={"GET"})
     */
    public function index(DescriptionRepository $descriptionRepository): Response
    {
        return $this->render('description/index.html.twig', [
            'descriptions' => $descriptionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{course}", name="description_new", methods={"GET","POST"})
     */
    public function new(Request $request, $course): Response
    {
        $course = $this->getDoctrine()
            ->getRepository(Course::class)->find($course);
        $description = new Description();
        $description->setCallnumber($course->getCallnumber());
        $description->setTerm($course->getTerm());
        $description->setCourse($course->getTitle());
        $description->setUser($this->getUser());
        $form = $this->createForm(DescriptionType::class, $description);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($description);
            $entityManager->flush();

            return $this->redirectToRoute('course_show', array('id' => $course->getId()));
        }

        return $this->render('description/new.html.twig', [
            'description' => $description,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="description_show", methods={"GET"})
     */
    public function show(Description $description): Response
    {
        return $this->render('description/show.html.twig', [
            'description' => $description,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="description_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Description $description): Response
    {
        $form = $this->createForm(DescriptionType::class, $description);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('description_index');
        }

        return $this->render('description/edit.html.twig', [
            'description' => $description,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="description_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Description $description): Response
    {
        if ($this->isCsrfTokenValid('delete'.$description->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($description);
            $entityManager->flush();
        }

        return $this->redirectToRoute('description_index');
    }
}
