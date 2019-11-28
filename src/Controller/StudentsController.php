<?php

namespace App\Controller;

use App\Entity\Offers;
use App\Entity\Sections;
use App\Entity\Students;
use App\Entity\Businesses;
use App\Form\StudentsType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/students")
 */
class StudentsController extends AbstractController
{
    /**
     * @Route("/", name="students_index", methods={"GET"})
     */
    public function index(): Response
    {
        $students = $this->getDoctrine()
            ->getRepository(Students::class)
            ->findAll();

        return $this->render('students/index.html.twig', [
            'students' => $students,

            'meta_title' => "Profil",
            'meta_desc' => "Profil apprenant",

        ]);
    }

    /**
     * @Route("/new", name="students_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $student = new Students();
        $form = $this->createForm(StudentsType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($student);
            $entityManager->flush();

            return $this->redirectToRoute('students_index');
        }

        return $this->render('students/new.html.twig', [
            'student' => $student,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/businesses", name="students_businesses", methods={"GET"})
     */
    public function businesses(Request $request): Response
    {
        //$user = $this->getUser();
        //$student = $user->student;

        $businesses = $this->getDoctrine()
            ->getRepository(Businesses::class)
            ->findAll();

        return $this->render('students/businesses.html.twig', [
            //'student' => $student,
            'businesses'=>$businesses,
            'meta_title'=>'Liste des entreprises'
           ]);
    }

    /**
     * @Route("/offers", name="students_offers", methods={"GET"})
     */
    public function offers(Request $request): Response
    {
        //$user = $this->getUser();
        //$student = $user->student;
        $offers = $this->getDoctrine()
            ->getRepository(Offers::class)
            ->findAll();

        $sections = $this->getDoctrine()
            ->getRepository(Sections::class)
            ->findAll();
        
        $keyword = $request->query->get("keyword");
        $location = $request->query->get("location");
        $section = $request->query->get("section");

        if($keyword != "") {
            $entityManager = $this->getDoctrine()->getManager();
            $queryBuilder = $entityManager->createQueryBuilder();
            $queryBuilder->select('o')
                ->from(Offers::class, 'o')
                ->where('o.title LIKE :keyword')
                ->orWhere('o.description LIKE :keyword')

                ->setParameter('keyword', '%'.$keyword.'%');
              
            $query = $queryBuilder->getQuery();
            $offers = $query->getResult();
        } else {
            $offers = $this->getDoctrine()
                ->getRepository(Offers::class)
                ->findAll();
        }

        return $this->render('students/offers.html.twig', [
            //'student' => $student,
            'offers'=> $offers,
            'sections'=> $sections,
            'keyword'=> $keyword,
            'location'=> $location,
            'section'=> $section,
            'meta_title' => "Liste des offres"
        ]);
    }

    /**
     * @Route("/offer/{id}", name="students_offer", methods={"GET"})
     */
    public function offer(Request $request, $id): Response
    {
        //$user = $this->getUser();
        //$student = $user->student;
        $offer = $this->getDoctrine()
            ->getRepository(Offers::class)
            ->findOneBy(['id'=>$id]);

        return $this->render('students/offer.html.twig', [
            //'student' => $student,
            'offer'=>$offer,
            'meta_title' => "Offre détaillée",
        ]);
    }

    /**
     * @Route("/{id}", name="students_show", methods={"GET"})
     */
    public function show(Students $student): Response
    {
        return $this->render('students/show.html.twig', [
            'student' => $student,
        ]);
    }

    /**
     * @Route("/business/{id}", name="students_business", methods={"GET"})
     */
    public function business(Request $request, $id): Response
    {
        //$user = $this->getUser();
        //$student = $user->student;

        $business = $this->getDoctrine()
            ->getRepository(Businesses::class)
            ->findOneBy(['id'=>$id]);

        $openPosts = $this->getDoctrine()
        ->getRepository(Offers::class)
        ->findBy(array('businesses' => $id));

        return $this->render('students/business.html.twig', [
            //'student' => $student,
            'business' => $business,
            'posts' => $openPosts,
            'meta_title'=>'Une entreprise'
        ]);
    }

    /**
     * @Route("/{id}/edit", name="students_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Students $student): Response
    {
        $form = $this->createForm(StudentsType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('students_index');
        }

        return $this->render('students/edit.html.twig', [
            'student' => $student,
            'form' => $form->createView(),
            'meta_title' => "Profil",
            'meta_desc' => "Profil apprenant",
        ]);
    }

    /**
     * @Route("/{id}", name="students_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Students $student): Response
    {
        if ($this->isCsrfTokenValid('delete'.$student->getid(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($student);
            $entityManager->flush();
        }

        return $this->redirectToRoute('students_index');
    }

    /**
     * @Route("/{id}/cv", name="students_cv", methods={"POST"})
     */
    public function generateCv()
    {
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML('<h1>CV !</h1>');
        $mpdf->Output();
    }

    /**
     * @Route("/{id}/lm", name="students_lm", methods={"POST"})
     */
    public function generateLm()
    {
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML('<h1>Lettre de motivation !</h1>');
        $mpdf->Output();
    }
}
