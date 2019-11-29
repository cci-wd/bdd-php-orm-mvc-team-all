<?php

namespace App\Controller;

use App\Entity\Businesses;
use App\Entity\City;
use App\Entity\Educations;
use App\Entity\Experiences;
use App\Entity\Offers;
use App\Entity\Sections;
use App\Entity\Skills;
use App\Entity\Students;
use App\Form\StudentsType;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/apprenants")
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

        $sections = $this->getDoctrine()
            ->getRepository(Sections::class)
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
        $student = new Students();
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
     * @Route("/entreprise", name="students_businesses", methods={"GET"})
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
            ->from(Businesses::class, 'b')
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

        if ($keyword != "") {
            $entityManager = $this->getDoctrine()->getManager();
            $queryBuilder = $entityManager->createQueryBuilder();
            $queryBuilder->select('o')
                ->from(Offers::class, 'o')
                ->where('o.title LIKE :keyword')
                ->orWhere('o.description LIKE :keyword')

                ->setParameter('keyword', '%' . $keyword . '%');

            $query = $queryBuilder->getQuery();
            $offers = $query->getResult();
        } else {
            $offers = $this->getDoctrine()
                ->getRepository(Offers::class)
                ->findAll();
        }

        return $this->render('students/offers.html.twig', [
            //'student' => $student,
            'offers' => $offers,
            'sections' => $sections,
            'keyword' => $keyword,
            'location' => $location,
            'section' => $section,
            'meta_title' => "Liste des offres",
        ]);
    }

    /**
     * @Route("/offre/{id}", name="students_offer", methods={"GET"})
     */
    public function offer(Request $request, $id): Response
    {
        //$user = $this->getUser();
        //$student = $user->student;
        $offer = $this->getDoctrine()
            ->getRepository(Offers::class)
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
            ->findOneBy(['id' => $id]);

        $openPosts = $this->getDoctrine()
            ->getRepository(Offers::class)
            ->findBy(array('businesses' => $id));

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
    public function edit(Request $request, Students $student, FileUploader $fileUploader): Response
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
    public function delete(Request $request, Students $student): Response
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
    public function generateCv(Students $student)
    {

        $educations = $this->getDoctrine()
            ->getRepository(Educations::class)
            ->findBy(['students' => $student->getId()]);

        $experiences = $this->getDoctrine()
            ->getRepository(Experiences::class)
            ->findBy(['students' => $student->getId()]);

        $skills = $this->getDoctrine()
            ->getRepository(Skills::class)
            ->findBy(['students' => $student->getId()]);

        $tabEduc = '';
        foreach ($educations as $education) {
            $tabEduc = $tabEduc . '<li>' . $education->getDateFrom()->format('Y') . '-' . $education->getDateTo()->format('Y') . ' ' . $education->getDegree() . ' ' . $education->getSpeciality() . ' ' . $education->getSchoolName() . '</li>';
        }

        $tabExp = '';
        foreach ($experiences as $experience) {
            $tabExp = $tabExp . '<li>' . $experience->getDateFrom()->format('Y') . '-' . $experience->getDateTo()->format('Y') . ' ' . $experience->getPost() . ' ' . $experience->getTitle() . '</li>';
        }

        $tabSkill = '';
        foreach ($skills as $skill) {
            $tabSkill = $tabSkill . '<li>' . $skill->getPercentage() . '% ' . $skill->getTitle() . '</li>';
        }

        $mpdf = new \Mpdf\Mpdf();

        $mpdf->WriteHTML('
        <table width="100%" style="border-style: solid; border-width: 2px;">
            <tr>
                <td width="33%">
                    <h1>' . $student->getFirstName() . ' ' . $student->getLastName() . '</h1>
                    <p>adresse: ' . $student->getLocation() . '<p>
                    <p>tel: ' . $student->getPhoneNumber() . '</p>
                    <p>email: ' . $student->getEmail() . '</p>
                </td>
                <td width="33%" align="center"></td>
                <td width="33%">
                    <div style="background-color: #cccccc; width: 150px; height: 200px;"></div>
                </td>
            </tr>
        </table>
        <div style="background-color: #cccccc; width: 100%; margin-top: 20px; text-align: center">
            <h3>Etudes</h3>
        </div>
        <div style="">
            <ul>
                ' . $tabEduc . '
            </ul>
        </div>
        <div style="background-color: #cccccc; width: 100%; margin-top: 20px; text-align: center">
            <h3>Expériences</h3>
        </div>
        <div style="">
            <ul>
                ' . $tabExp . '
            </ul>
        </div>
        <div style="background-color: #cccccc; width: 100%; margin-top: 20px; text-align: center">
            <h3>Compétences</h3>
        </div>
        <div style="">
            <ul>
                ' . $tabSkill . '
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
