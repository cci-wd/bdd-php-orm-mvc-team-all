<?php

namespace App\Controller;

use App\Entity\Sections;
use App\Entity\Students;
use App\Entity\Businesses;
use App\Entity\Educations;
use App\Entity\Experiences;
use App\Form\BusinessesType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/businesses")
 */
class BusinessesController extends AbstractController
{
    /**
     * @Route("/", name="businesses_index", methods={"GET"})
     */
    public function index(): Response
    {
        $businesses = $this->getDoctrine()
            ->getRepository(Businesses::class)
            ->findAll();

        return $this->render('businesses/index.html.twig', [
            'businesses' => $businesses,
            'meta_title' => 'CCI-LINK, votre site de rencontres professionnel au CFA',
            'meta_desc' => 'Description des metas',
        ]);
    }

    /**
     * @Route("/new", name="businesses_new", methods={"GET","POST"})
     */
    function new (Request $request): Response {
        $business = new Businesses();
        $form = $this->createForm(BusinessesType::class, $business);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($business);
            $entityManager->flush();

            return $this->redirectToRoute('businesses_index');
        }

        return $this->render('businesses/new.html.twig', [
            'business' => $business,
            'form' => $form->createView(),
            'meta_title' => 'CCI-LINK, votre site de rencontres professionnel au CFA',
            'meta_desc' => 'Description des metas',
        ]);
    }

    /**
     * @Route("/students", name="businesses_students_list", methods={"GET"})
     */
    public function students(): Response
    {
        $students = $this->getDoctrine()
            ->getRepository(Students::class)
            ->findAll();

        $sections = $this->getDoctrine()
            ->getRepository(Sections::class)
            ->findAll();

        return $this->render('businesses/students.html.twig', [
            'students' => $students,
            'sections' => $sections,
            'meta_title' => 'CCI-LINK, votre site de rencontres professionnel au CFA',
            'meta_desc' => 'Description des metas',
        ]);
    }

    /**
     * @Route("/student/{id}", name="businnesses_student_show", methods={"GET"})
     */
    public function student(Students $student): Response
    {
        $educations = $this->getDoctrine()
            ->getRepository(Educations::class)
            ->findBy(array('students' => $student->getId()));

        $experiences = $this->getDoctrine()
            ->getRepository(Experiences::class)
            ->findBy(array('students' => $student->getId()));

        return $this->render('businesses/student.html.twig', [
            'student' => $student,
            'educations' => $educations,
            'experiences' => $experiences,
        ]);
    }

    /**
     * @Route("/{id}", name="businesses_show", methods={"GET"})
     */
    public function show(Businesses $business): Response
    {
        return $this->render('businesses/show.html.twig', [
            'business' => $business,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="businesses_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Businesses $business): Response
    {
        $form = $this->createForm(BusinessesType::class, $business);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('businesses_index');
        }

        return $this->render('businesses/edit.html.twig', [
            'business' => $business,
            'form' => $form->createView(),
            'meta_title' => 'CCI-LINK, votre site de rencontres professionnel au CFA',
            'meta_desc' => 'Description des metas',
        ]);
    }

    /**
     * @Route("/{id}", name="businesses_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Businesses $business): Response
    {
        if ($this->isCsrfTokenValid('delete' . $business->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($business);
            $entityManager->flush();
        }

        return $this->redirectToRoute('businesses_index');
    }
}
