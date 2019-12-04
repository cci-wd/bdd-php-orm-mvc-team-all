<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\User;
use App\Entity\Offer;
use App\Entity\Business;
use App\Form\BusinessType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/entreprise")
 * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_STUDENT') or is_granted('ROLE_BUSINESS')")
 */
class BusinessController extends AbstractController
{
    /**
     * @Route("/", name="business_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->redirectToRoute('business_list');
    }

    /**
     * @Route("/liste", name="business_list", methods={"GET"})
     */
    function list(Request $request): Response {
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

        if ($location && $location != "Toutes les communes") {
            $queryBuilder->andWhere('b.location = :location')
                ->setParameter('location', $location);
        }

        $query = $queryBuilder->getQuery();
        $businesses = $query->getResult();

        return $this->render('businesses/index.html.twig', [
            'businesses' => $businesses,
            'parameters' => [
                'keyword' => $keyword,
                'location' => $location,

            ],
            'location' => $location,
            'cities' => $cities,
            'meta_title' => 'Liste des entreprises',
        ]);
    }

    /**
     * @Route("/mon-profil", name="business_profile", methods={"GET", "POST"})
     * @Security("is_granted('ROLE_BUSINESS')")
     */
    public function profile(Request $request): Response
    {
        $business = $this->getUser()->getBusiness();

        $form = $this->createForm(BusinessType::class, $business);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('business_profile');
        }

        return $this->render('businesses/edit.html.twig', [
            'business' => $business,
            'form' => $form->createView(),
            'meta_title' => "Profil",
            'meta_desc' => "Profil apprenant",
        ]);
    }

    /**
     * @Route("/creer", name="business_new", methods={"GET","POST"})
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function create(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User();
        $business = new Business();
        $form = $this->createForm(BusinessType::class, $business);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setUsername($business->getEmail());
            $user->setRoles(['ROLE_BUSINESS']);
            $user->setPassword($encoder->encodePassword($user, random_bytes(8)));

            $business->setUser($user);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->persist($business);
            $entityManager->flush();

            return $this->redirectToRoute('business_list');
        }

        return $this->render('businesses/new.html.twig', [
            'business' => $business,
            'form' => $form->createView(),
            'meta_title' => 'CCI-LINK, votre site de rencontres professionnel au CFA',
            'meta_desc' => 'Description des metas',
        ]);
    }

    /**
     * @Route("/{id}", name="business_show", methods={"GET"})
     */
    public function show(Business $business): Response
    {
        $offers = $this->getDoctrine()
            ->getRepository(Offer::class)
            ->findBy(array('business' => $business->getId()));

        return $this->render('businesses/show.html.twig', [
            'business' => $business,
            'offers' => $offers,
            'meta_title' => 'CCI-LINK, votre site de rencontres professionnel au CFA',
            'meta_desc' => 'Description des metas',
        ]);
    }

    /**
     * @Route("/{id}/modifier", name="business_edit", methods={"GET","POST"})
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function edit(Request $request, Business $business): Response
    {
        $form = $this->createForm(BusinessType::class, $business);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('business_list');
        }

        return $this->render('businesses/edit.html.twig', [
            'business' => $business,
            'form' => $form->createView(),
            'meta_title' => 'CCI-LINK, votre site de rencontres professionnel au CFA',
            'meta_desc' => 'Description des metas',
        ]);
    }

    /**
     * @Route("/{id}", name="business_delete", methods={"DELETE"})
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function delete(Request $request, Business $business): Response
    {
        if ($this->isCsrfTokenValid('delete' . $business->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($business);
            $entityManager->flush();
        }

        return $this->redirectToRoute('business_list');
    }
}
