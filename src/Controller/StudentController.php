<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\User;
use App\Entity\Offer;
use App\Entity\Skill;
use App\Entity\Section;
use App\Entity\Student;
use Twilio\Rest\Client;
use App\Entity\Business;
use App\Entity\Education;
use App\Form\StudentType;
use App\Entity\Experience;
use App\Service\FileUploader;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/apprenant")
 * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_STUDENT') or is_granted('ROLE_BUSINESS')")
 */
class StudentController extends AbstractController
{
    /**
     * @Route("/", name="student_index", methods={"GET"})
     */
    public function index()
    {
        return $this->redirectToRoute("student_list");
    }

    /**
     * @Route("/liste", name="student_list", methods={"GET"})
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_BUSINESS')")
     */
    function list(Request $request, PaginatorInterface $paginator): Response {
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
            ->select('student')
            ->from(Student::class, 'student')
            ->where('student.firstName LIKE :keyword')
            ->setParameter('keyword', '%' . $keyword . '%');

        if ($location && $location != "Toutes les communes") {
            $queryBuilder->andWhere('student.location = :location')
                ->setParameter('location', $location);
        }

        if ($section && $section != "Toutes les sections") {
            $queryBuilder
                ->leftJoin('student.section', 'section')
                ->andWhere('section.name = :section')
                ->setParameter('section', $section);
        }

        $query = $queryBuilder->getQuery();

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            1 /*limit per page*/
        );

        return $this->render('students/index.html.twig', [
            'students' => $pagination,
            'parameters' => [
                'keyword' => $keyword,
                'location' => $location,
                'section' => $section,
            ],
            'sections' => $sections,
            'cities' => $cities,
            'meta_title' => "Liste des alternants",
        ]);
    }

    /**
     * @Route("/mon-profil", name="student_profile", methods={"GET","POST"})
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_STUDENT')")
     */
    public function profile(Request $request, FileUploader $fileUploader): Response
    {
        $student = $this->getUser()->getStudent();

        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $image */
            $image = $form['image']->getData();
            if ($image) {
                $imageName = $fileUploader->upload($image);
                $student->setImage($imageName);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('student_profile');
        }

        return $this->render('students/edit.html.twig', [
            'student' => $student,
            'form' => $form->createView(),
            'form_title' => "Mon profil",
            'form_desc' => "Modifier mon profil",
        ]);
    }

    /**
     * @Route("/creer", name="student_new", methods={"GET","POST"})
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function create(Request $request, FileUploader $fileUploader, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User();
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $image */
            $image = $form['image']->getData();
            if ($image) {
                $imageName = $fileUploader->upload($image);
                $student->setImage($imageName);
            }

            $user->setRoles(['ROLE_STUDENT']);
            $user->setUsername($student->getPhoneNumber());
            $user->setPassword($encoder->encodePassword($user, random_bytes(8)));

            $student->setPhoneNumber('+687' . $form['phoneNumber']->getData());
            $student->setUser($user);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->persist($student);
            $entityManager->flush();

            return $this->redirectToRoute('student_list');
        }

        return $this->render('students/new.html.twig', [
            'student' => $student,
            'form' => $form->createView(),
            'form_title' => "Création",
            'form_desc' => "Création d'un compte apprenant",
        ]);
    }

    /**
     * @Route("/{id}", name="student_show", methods={"GET"})
     */
    public function show(Student $student): Response
    {
        $sections = $this->getDoctrine()
            ->getRepository(Section::class)
            ->findAll();

        $educations = $this->getDoctrine()
            ->getRepository(Education::class)
            ->findBy(array('student' => $student->getId()));

        $experiences = $this->getDoctrine()
            ->getRepository(Experience::class)
            ->findBy(array('student' => $student->getId()));
        // dd($student);

        return $this->render('students/show.html.twig', [
            'student' => $student,
            'educations' => $educations,
            'experiences' => $experiences,
        ]);
    }

    /**
     * @Route("/{id}/modifier", name="student_edit", methods={"GET","POST"})
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function edit(Request $request, Student $student, FileUploader $fileUploader): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $image */
            $image = $form['image']->getData();
            if ($image) {
                $imageName = $fileUploader->upload($image);
                $student->setImage($imageName);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('student_list');
        }

        return $this->render('students/edit.html.twig', [
            'student' => $student,
            'form' => $form->createView(),
            'meta_title' => "Profil",
            'meta_desc' => "Profil apprenant",
            'form_title' => "Modification",
            'form_desc' => "Modifier un compte apprenant",
        ]);
    }

    /**
     * @Route("/{id}", name="student_delete", methods={"DELETE"})
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function delete(Request $request, Student $student): Response
    {
        if ($this->isCsrfTokenValid('delete' . $student->getid(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($student);
            $entityManager->flush();
        }

        return $this->redirectToRoute('student_list');
    }

    /**
     * @Route("/{id}/cv", name="student_cv", methods={"GET"})
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_STUDENT')")
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
        foreach ($educations as $education) {
            $tabEduc = $tabEduc . '
                <li style="list-style:none">' . $education->getDateFrom()->format('Y') . '-' . $education->getDateTo()->format('Y') . '
                     <span>' . $education->getDegree() . ', ' . $education->getSpeciality() . ' ' . $education->getSchoolName() . '</span>
                </li>'
            ;
        }

        $tabExp = '';
        foreach ($experiences as $experience) {
            $tabExp = $tabExp . '
                <li style="list-style:none">' . $experience->getDateFrom()->format('Y') . '-' . $experience->getDateTo()->format('Y') . '
                    <span>' . $experience->getPost() . ' ' . $experience->getTitle() . '</span>
                </li>'
            ;
        }

        $tabSkill = '';
        foreach ($skills as $skill) {
            $tabSkill = $tabSkill . '
                <li style="list-style:none">' . $skill->getPercentage() . '% </td> ' . $skill->getTitle() . '
                </li>'
            ;
        }

        $mpdf = new \Mpdf\Mpdf();

        $mpdf->WriteHTML('
        <table width="100%" >
            <tr>
                <td width="33%">
                    <h3>' . $student->getFirstName() . ' ' . $student->getLastName() . '</h3>
                    <p>Adresse : ' . $student->getLocation() . '<p>
                    <p>Téléphone : ' . $student->getPhoneNumber() . '</p>
                    <p>Email : ' . $student->getEmail() . '</p>
                </td>
            </tr>
        </table>
        <div style="background-color: #cccccc; width:100%;height:5px; margin-top: 20px; text-align: center">
            <h3>Formations</h3>
        </div>
        <br>
        <div style="" width="100%" >
            <ul>
                ' . $tabEduc . '
            </ul>
        </div>
        <div style="background-color: #cccccc; width: 100%; margin-top: 20px; text-align: center">
            <h3>Expériences proféssionnelles </h3>
        </div>
        <br>
        <div style="" width="100%">
            <ul>
                ' . $tabExp . '
            </ul>
        </div>
        <div style="background-color: #cccccc; width: 100%; margin-top: 20px; text-align: center">
            <h3>Compétences</h3>
        </div>
        <br>
        <div style="" width="100%">
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
     * @Route("/{id}/lm", name="student_lm", methods={"POST"})
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_STUDENT')")
     */
    public function generateLm(Student $student, Business $business, Offer $offer, Section $section)
    {
        $object = "Objet : Candidature à l'offre de contrat en alternance de" . ' ' . $offer->getTitle();
        $signature = $student->getFirstName() . ' ' . $student->getLastName();
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
                <h3>' . $student->getFirstName() . ' ' . $student->getLastName() . '</h3>
                <p>Adresse: ' . $student->getLocation() . '<p>
                <p>Téléphone: ' . $student->getPhoneNumber() . '</p>
                <p>Email: ' . $student->getEmail() . '</p>
            </td>
        </tr>
        <tr>
            <td style="text-align:right">
                <h3>' . $business->getName() . '</h3>
                <p>Adresse: ' . $business->getLocation() . '<p>
                <p>Téléphone: ' . $business->getPhoneNumber() . '</p>
                <p>Email: ' . $business->getEmail() . '</p>
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
            <p>' . $object . '</p>
            </td>
        </tr>
        <tr>
            <td style="">
            <p>' . $text . '</p>
            </td>
        </tr>

    </table>


        ');

        $mpdf->Output();
    }

    /**
     * @Route("/{id}/invitation", name="student_invitation", methods={"POST"})
     */
    public function invitation(Request $request, Student $student, Client $twilio, ContainerInterface $container)
    {
        $user = $student->getUser();

        if(!$user->getStatus()) {
            $token = rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
            $url = $request->getHttpHost() . '/registration/' . $token;

            try {
                $twilio->messages->create(
                    $student->getPhoneNumber(),
                    array(
                        "from" => $container->getParameter('twilio_number'),
                        "body" => "Cliquez ici pour rejoindre la platforme CCI Link : " . $url
                    )
                );
            } catch (RestException $error) {
                return new Response($error, Response::HTTP_FORBIDDEN);
            }

            $user->setToken($token);
        } else {
            return new Response('The student is already active.', Response::HTTP_FORBIDDEN);
        }
        return new Response('The student has been invited;', Response::HTTP_OK);
    }
}
