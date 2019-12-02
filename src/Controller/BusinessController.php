<?php

namespace App\Controller;

use App\Entity\Business;
use App\Entity\City;
use App\Entity\Offer;
use App\Form\BusinessType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/entreprise")
 * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_APPRENANT') or is_granted('ROLE_ENTREPRISE')")
 */
class BusinessController extends AbstractController
{
    /**
     * @Route("/", name="businesses_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->redirectToRoute('businesses_list');
    }

    /**
     * @Route("/liste", name="businesses_list", methods={"GET"})
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
            'keyword' => $keyword,
            'location' => $location,
            'cities' => $cities,
            'meta_title' => 'Liste des entreprises',
        ]);
    }

    /**
     * @Route("/mon-profil", name="business_profil", methods={"GET", "POST"})
     * @Security("is_granted('ROLE_ENTREPRISE')")
     */
    public function profile(Request $request): Response
    {
        $business = $this->getUser()->getBusiness();

        $form = $this->createForm(BusinessType::class, $business);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('businesses_list');
        }

        return $this->render('businesses/edit.html.twig', [
            'business' => $business,
            'form' => $form->createView(),
            'meta_title' => "Profil",
            'meta_desc' => "Profil apprenant",
        ]);
    }

    /**
     * @Route("/creer", name="businesses_new", methods={"GET","POST"})
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function create(Request $request): Response
    {
        $business = new Business();
        $form = $this->createForm(BusinessType::class, $business);
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
     * @Route("/{id}", name="businesses_show", methods={"GET"})
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
     * @Route("/{id}/modifier", name="businesses_edit", methods={"GET","POST"})
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function edit(Request $request, Business $business): Response
    {
        $form = $this->createForm(BusinessType::class, $business);
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
     * @Security("is_granted('ROLE_ADMIN')")
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
