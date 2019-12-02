<?php

namespace App\Controller;

use App\Entity\Business;
use App\Entity\City;
use App\Entity\Education;
use App\Entity\Experience;
use App\Entity\Offer;
use App\Entity\Section;
use App\Entity\Skill;
use App\Entity\Student;
use App\Form\StudentsType;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/apprenants")
 */
class StudentController extends AbstractController
{
    /**
     * @Route("/", name="students_index", methods={"GET"})
     */
    public function index(): Response
    {
        $students = $this->getDoctrine()
            ->getRepository(Student::class)
            ->findAll();

        $sections = $this->getDoctrine()
            ->getRepository(Section::class)
            ->findAll();

        return $this->render('students/index.html.twig', [
            'students' => $students,
            'sections' => $sections,
        ]);
    }

    /**
     * @Route("/creer", name="students_new", methods={"GET","POST"})
     */
    public function create(Request $request, FileUploader $fileUploader): Response
    {
        $student = new Student();
        $form = $this->createForm(StudentsType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $image */
            $image = $form['image']->getData();
            if ($image) {
                $imageName = $fileUploader->upload($image);
                $product->setImage($imageName);
            }

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
     * @Route("/entreprises", name="students_businesses", methods={"GET"})
     */
    public function businesses(Request $request): Response
    {
        $cities = $this->getDoctrine()
            ->getRepository(City::class)
            ->findAll();

        $keyword = $request->query->get("keyword");
        $location = $request->query->get("location");

        $entityManager = $this->getDoctrine()->getManager();
        $queryBuilder = $entityManager->createQueryBuilder();
        $queryBuilder
            ->select('b')
            ->from(Business::class, 'b')
            ->where('b.name LIKE :keyword')
            ->setParameter('keyword', '%' . $keyword . '%');

        if ($location != "Toutes les communes") {
            $queryBuilder->andWhere('b.location = :location')
                ->setParameter('location', $location);
        }

        $query = $queryBuilder->getQuery();
        $businesses = $query->getResult();

        return $this->render('students/businesses.html.twig', [
            'businesses' => $businesses,
            'keyword' => $keyword,
            'location' => $location,
            'cities' => $cities,
            'meta_title' => 'Liste des entreprises',
        ]);
    }

    /**
     * @Route("/offres", name="students_offers", methods={"GET"})
     */
    public function offers(Request $request): Response
    {
        $sections = $this->getDoctrine()
            ->getRepository(Section::class)
            ->findAll();

        $cities = $this->getDoctrine()
            ->getRepository(City::class)
            ->findAll();

        $keyword = $request->query->get("keyword");
        $location = $request->query->get("location");
        $section = $request->query->get("section");

        $entityManager = $this->getDoctrine()->getManager();
        $queryBuilder = $entityManager->createQueryBuilder();
        $queryBuilder
            ->select('o')
            ->from(Offers::class, 'o')
            ->where('o.title LIKE :keyword')
            ->setParameter('keyword', '%' . $keyword . '%');

        if ($location != "Toutes les communes") {
            $queryBuilder->andWhere('o.location = :location')
                ->setParameter('location', $location);
        }

        if ($section != "Toutes les sections") {
            $queryBuilder
                ->leftJoin('o.sections', 'sections')
                ->andWhere('sections.name = :section')
                ->setParameter('section', $section);
        }

        $query = $queryBuilder->getQuery();
        $offers = $query->getResult();

        return $this->render('students/offers.html.twig', [
            'offers' => $offers,
            'parameters' => [
                'keyword' => $keyword,
                'location' => $location,
                'section' => $section,
            ],
            'cities' => $cities,
            'sections' => $sections,
            'meta_title' => "Liste des offres",
        ]);
    }

    /**
     * @Route("/offre/{id}", name="students_offer", methods={"GET"})
     */
    public function offer(Request $request, $id): Response
    {
        $offer = $this->getDoctrine()
            ->getRepository(Offer::class)
            ->findOneBy(['id' => $id]);

        return $this->render('students/offer.html.twig', [
            //'student' => $student,
            'offer' => $offer,
            'meta_title' => "Offre détaillée",
        ]);
    }

    /**
     * @Route("/{id}", name="students_show", methods={"GET"})
     */
    public function show(Student $student): Response
    {
        return $this->render('students/show.html.twig', [
            'student' => $student,
        ]);
    }

    /**
     * @Route("/entreprise/{id}", name="students_business", methods={"GET"})
     */
    public function business(Request $request, $id): Response
    {
        $business = $this->getDoctrine()
            ->getRepository(Business::class)
            ->findOneBy(['id' => $id]);

        $openPosts = $this->getDoctrine()
            ->getRepository(Offer::class)
            ->findBy(array('business' => $id));

        return $this->render('students/business.html.twig', [
            //'student' => $student,
            'business' => $business,
            'posts' => $openPosts,
            'meta_title' => 'Une entreprise',
        ]);
    }

    /**
     * @Route("/{id}/modifier", name="students_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Student $student, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(StudentsType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $image */
            $image = $form['image']->getData();
            if ($image) {
                $imageName = $fileUploader->upload($image);
                $student->setImage($imageName);
            }

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
    public function delete(Request $request, Student $student): Response
    {
        if ($this->isCsrfTokenValid('delete' . $student->getid(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($student);
            $entityManager->flush();
        }

        return $this->redirectToRoute('students_index');
    }

    /**
     * @Route("/{id}/cv", name="students_cv", methods={"GET"})
     */
    public function generateCv(Student $student)
    {

        $educations = $this->getDoctrine()
            ->getRepository(Education::class)
            ->findBy(['student' => $student->getId()]);

        $experiences = $this->getDoctrine()
            ->getRepository(Experience::class)
            ->findBy(['student' => $student->getId()]);

        $skills = $this->getDoctrine()
            ->getRepository(Skill::class)
            ->findBy(['student' => $student->getId()]);

        $tabEduc = '';
        foreach ( $educations as $education){
            $tabEduc = $tabEduc.'
                <li style="list-style:none">'.$education->getDateFrom()->format('Y').'-'.$education->getDateTo()->format('Y').'
                     <span>'.$education->getDegree().', '.$education->getSpeciality().' '.$education->getSchoolName().'</span>
                </li>'
            ;
        }

        $tabExp = '';
        foreach ( $experiences as $experience){
            $tabExp = $tabExp.'
                <li style="list-style:none">'.$experience->getDateFrom()->format('Y').'-'.$experience->getDateTo()->format('Y').'
                    <span>'.$experience->getPost().' '.$experience->getTitle().'</span>
                </li>'
            ;
        }

        $tabSkill = '';
        foreach ( $skills as $skill){
            $tabSkill = $tabSkill.'
                <li style="list-style:none">'.$skill->getPercentage().'% </td> '.$skill->getTitle().'
                </li>'
            ;
        }

        $mpdf = new \Mpdf\Mpdf();

        $mpdf->WriteHTML('
        <table width="100%" >
            <tr>
                <td width="33%">
                    <h3>'.$student->getFirstName().' '.$student->getLastName().'</h3>
                    <p>Adresse : '.$student->getLocation().'<p>
                    <p>Téléphone : '.$student->getPhoneNumber().'</p>
                    <p>Email : '.$student->getEmail().'</p>
                </td>
            </tr>
        </table>
        <div style="background-color: #cccccc; width:100%;height:5px; margin-top: 20px; text-align: center">
            <h3>Formations</h3>  
        </div>
        <br>
        <div style="" width="100%" >
            <ul>
                '.$tabEduc.'
            </ul>
        </div>
        <div style="background-color: #cccccc; width: 100%; margin-top: 20px; text-align: center">
            <h3>Expériences proféssionnelles </h3>
        </div>
        <br>
        <div style="" width="100%">
            <ul>
                '.$tabExp.'
            </ul>
        </div>
        <div style="background-color: #cccccc; width: 100%; margin-top: 20px; text-align: center">
            <h3>Compétences</h3>
        </div>
        <br>
        <div style="" width="100%">
            <ul>
                '.$tabSkill.'
            </ul>
        </div>
        '
    );

    $mpdf->SetHTMLFooter('
    <table width="100%">
        <tr>
            <td width="33%">{DATE j-m-Y}</td>
            <td width="33%" align="center">{PAGENO}/{nbpg}</td>
            <td width="33%" style="text-align: right;">Mon CV</td>
        </tr>
    </table>');
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
