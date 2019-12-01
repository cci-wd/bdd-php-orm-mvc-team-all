<?php

namespace App\Controller;

use App\Entity\Section;
use App\Entity\Student;
use App\Entity\Business;
use App\Entity\Offer;
use App\Entity\Education;
use App\Entity\Experience;
use App\Form\BusinessesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/entreprises")
 */
class BusinessController extends AbstractController
{
    /**
     * @Route("/", name="businesses_index", methods={"GET"})
     */
    public function index(): Response
    {
        $businesses = $this->getDoctrine()
            ->getRepository(Business::class)
            ->findAll();

        return $this->render('businesses/index.html.twig', [
            'businesses' => $businesses,
            'meta_title' => 'Liste des entreprises',
            'meta_desc' => 'Description des metas',
        ]);
    }

    /**
     * @Route("/creer", name="businesses_new", methods={"GET","POST"})
     */
    function create(Request $request): Response {
        $business = new Business();
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
     * @Route("/apprenants", name="businesses_students_list", methods={"GET"})
     */
    public function students(): Response
    {
        $students = $this->getDoctrine()
            ->getRepository(Student::class)
            ->findAll();

        $sections = $this->getDoctrine()
            ->getRepository(Section::class)
            ->findAll();

        return $this->render('businesses/students.html.twig', [
            'students' => $students,
            'sections' => $sections,
            'meta_title' => 'CCI-LINK, votre site de rencontres professionnel au CFA',
            'meta_desc' => 'Description des metas',
        ]);
    }

    /**
     * @Route("/apprenant/{id}", name="businnesses_student_show", methods={"GET"})
     */
    public function student(Student $student): Response
    {
        $educations = $this->getDoctrine()
            ->getRepository(Education::class)
            ->findBy(array('student' => $student->getId()));

        $experiences = $this->getDoctrine()
            ->getRepository(Experience::class)
            ->findBy(array('student' => $student->getId()));

        return $this->render('businesses/student.html.twig', [
            'student' => $student,
            'educations' => $educations,
            'experiences' => $experiences,
        ]);
    }

    /**
     * @Route("/{id}", name="businesses_show", methods={"GET"})
     */
    public function show(Business $business): Response
    {
        return $this->render('businesses/show.html.twig', [
            'business' => $business,
            'meta_title' => 'CCI-LINK, votre site de rencontres professionnel au CFA',
            'meta_desc' => 'Description des metas',
        ]);
    }

    /**
     * @Route("/{id}/modifier", name="businesses_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Business $business): Response
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
    public function delete(Request $request, Business $business): Response
    {
        if ($this->isCsrfTokenValid('delete' . $business->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($business);
            $entityManager->flush();
        }

        return $this->redirectToRoute('businesses_index');
    }
}
