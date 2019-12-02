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
            ->findBy(['students' => $student->getId()]);

        $experiences = $this->getDoctrine()
            ->getRepository(Experience::class)
            ->findBy(['students' => $student->getId()]);

        $skills = $this->getDoctrine()
            ->getRepository(Skill::class)
            ->findBy(['students' => $student->getId()]);

        $tabEduc = '';
        foreach ( $educations as $education){
            $tabEduc = $tabEduc.'<li>'.$education->getDateFrom()->format('Y').'-'.$education->getDateTo()->format('Y').' '.$education->getDegree().' '.$education->getSpeciality().' '.$education->getSchoolName().'</li>';
        }

        $tabExp = '';
        foreach ( $experiences as $experience){
            $tabExp = $tabExp.'<li>'.$experience->getDateFrom()->format('Y').'-'.$experience->getDateTo()->format('Y').' '.$experience->getPost().' '.$experience->getTitle().'</li>';
        }

        $tabSkill = '';
        foreach ( $skills as $skill){
            $tabSkill = $tabSkill.'<li>'.$skill->getPercentage().'% '.$skill->getTitle().'</li>';
        }

        $mpdf = new \Mpdf\Mpdf();

        $mpdf->WriteHTML('
        <table width="100%" style="border-style: solid; border-width: 2px;">
            <tr>
                <td width="33%">
                    <h1>'.$student->getFirstName().' '.$student->getLastName().'</h1>
                    <p>adresse: '.$student->getLocation().'<p>
                    <p>tel: '.$student->getPhoneNumber().'</p>
                    <p>email: '.$student->getEmail().'</p>
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
                '.$tabEduc.'
            </ul>
        </div>
        <div style="background-color: #cccccc; width: 100%; margin-top: 20px; text-align: center">
            <h3>Expériences</h3>
        </div>
        <div style="">
            <ul>
                '.$tabExp.'
            </ul>
        </div>
        <div style="background-color: #cccccc; width: 100%; margin-top: 20px; text-align: center">
            <h3>Compétences</h3>
        </div>
        <div style="">
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
     * @Route("/{id}/lm", name="students_lm", methods={"GET"})
     */
    public function generateLm(Student $student, Business $business, Offer $offer, Section $section)
    {
        $object = "Objet : Candidature à l'offre de contrat en alternance de".' '. $offer->getTitle();
        $signature = $student->getFirstName().' '.$student->getLastName();
        $company = $business->getName();
        $section = $section->getName();

        $text = "<br>Madame, Monsieur,<br><br>

        Actuellement en classe de terminale et étant admis en $section, au sein de la CCI Formation Alternance, je suis à la recherche d'un contrat d'apprentissage pour la rentrée 2020, à partir du 2 septembre pour une durée de X mois (toujours préciser de manière claire ses disponibilités).<br><br>
        
        Votre entreprise $company, leader dans le domaine des... (acteur incontournable dans le monde de la distribution... montrez ici que vous connaissez bien l'entreprise en connaissant son secteur, et si possible réussir à caser que vous êtes séduit par l'entreprise), représente pour moi une très grande opportunité de m'ouvrir au domaine de l'industrie grâce à ses activités diverses. Passionné par la finance, je souhaite maintenant me former dans ce domaine pour y travailler dans le long terme. (indiquez ici votre projet à long terme, l'idée étant de montrer que vous souhaitez vous engager de manière très réfléchie dans ce secteur, vers ce type de métiers).<br><br>
        
        J'ai choisi cette formation en alternance, sur une durée de xx mois, car elle représente pour moi le moyen le plus efficace de mettre à profit mes connaissances et d'acquérir les savoirs pratiques nécessaires à l'obtention future de mon diplôme et la construction de mon début de carrière.
        En alliant cours théorique et pratique je serai très opérationnel et compétent pour remplir toutes les missions que vous pourrez me confier comme l'organisation d'événements ou encore la gestion des factures. (indiquer ici des missions que vous aurez pu voir dans l'annonce d'alternance, ce qui montre que vous avez bien lu l'annonce et que vous avez pu en ressortir un ou deux points clés).<br><br>
        
        Dynamique et motivé, je suis déterminé à me former rapidement et efficacement, et je suis prêt à m'investir totalement afin de mener à bien les tâches qui me seront confiées.<br><br>
        
        C'est avec plaisir que je vous exposerai de vive voix mes motivations au cours d'un entretien.<br><br>
        
        Dans l'attente de votre réponse, je vous prie de croire, Madame, Monsieur, à l'assurance de toute ma considération.<br><br>
        
        $signature ";
        
        
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML('<h3 style="text-align:center">Lettre de motivation</h3> 
        <table width="100%">
        <tr>
            <td>
                <h3>'.$student->getFirstName().' '.$student->getLastName().'</h3>
                <p>Adresse: '.$student->getLocation().'<p>
                <p>Téléphone: '.$student->getPhoneNumber().'</p>
                <p>Email: '.$student->getEmail().'</p>
            </td>
        </tr>
        <tr>
            <td style="text-align:right">
                <h3>'.$business->getName().'</h3>
                <p>Adresse: '.$business->getLocation().'<p>
                <p>Téléphone: '.$business->getPhoneNumber().'</p>
                <p>Email: '.$business->getEmail().'</p>
            </td>
        </tr>
        <br>
        <tr>
            <td style="text-align:right">
            <p>Nouméa, le 02 Décembre 2019, </p>
            </td>
        </tr>
        <br>
        <tr>
            <td style="">
            <p>'.$object.'</p>
            </td>
        </tr>
        <tr>
            <td style="">
            <p>'.$text.'</p>
            </td>
        </tr>

    </table>

        
        ');
       
        $mpdf->Output();
    }
}
