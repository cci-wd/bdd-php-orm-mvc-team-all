<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\Offer;
use App\Entity\Section;
use App\Form\OfferType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/offre")
 * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_STUDENT') or is_granted('ROLE_BUSINESS')")
 */
class OfferController extends AbstractController
{
    /**
     * @Route("/", name="offer_index", methods={"GET"})
     */
    public function index(Request $request): Response
    {
        return $this->redirectToRoute('offer_list');
    }

    /**
     * @Route("/liste", name="offer_list", methods={"GET"})
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
            ->select('o')
            ->from(Offer::class, 'o')
            ->where('o.title LIKE :keyword')
            ->setParameter('keyword', '%' . $keyword . '%');

        if ($location && $location != "Toutes les communes") {
            $queryBuilder->andWhere('o.location = :location')
                ->setParameter('location', $location);
        }

        if ($section && $section != "Toutes les sections") {
            $queryBuilder
                ->leftJoin('o.section', 'section')
                ->andWhere('section.name = :section')
                ->setParameter('section', $section);
        }

        $query = $queryBuilder->getQuery();

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('offers/index.html.twig', [
            'offers' => $pagination,
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
     * @Route("/creer", name="offer_new", methods={"GET","POST"})
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_BUSINESS')")
     */
    public function create(Request $request): Response
    {
        $user = $this->getUser();

        $offer = new Offer();
        $offer->setStatus(0);
        $offer->setBusiness($user->getBusiness());
        $offer->setPublishDate(new \DateTime());
        $form = $this->createForm(OfferType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($offer);
            $entityManager->flush();

            return $this->redirectToRoute('offer_list');
        }

        return $this->render('offers/new.html.twig', [
            'offer' => $offer,
            'form' => $form->createView(),
            'meta_desc' => 'Créer une annonce',
            'meta_title' => "Création d'annonce",
            'form_title' => "Ajouter une annonce",
            'form_desc' => "",
            /* 'errors' => $errors */
        ]);
    }

    /**
     * @Route("/{id}", name="offer_show", methods={"GET"})
     */
    public function show(Offer $offer): Response
    {
        return $this->render('offers/show.html.twig', [
            'offer' => $offer,
            'meta_title' => "Voir l'annonce",
            'meta_desc' => "Voir une annonce",
        ]);
    }

    /**
     * @Route("/{id}/modifier", name="offer_edit", methods={"GET","POST"})
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_BUSINESS')")
     */
    public function edit(Request $request, Offer $offer): Response
    {
        $offer->setStatus(0);
        $offer->setPublishDate(new \DateTime());
        $form = $this->createForm(OfferType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('offer_list');
        }

        return $this->render('offers/edit.html.twig', [
            'offer' => $offer,
            'form' => $form->createView(),
            'form_title' => "Modifiez votre annonce",
            'form_desc' => "En quelques clics seulement !",
            'meta_title' => "Modifiez votre annonce",
            'meta_desc' => "En quelques clics seulement !",
        ]);
    }

    /**
     * @Route("/{id}", name="offer_delete", methods={"DELETE"})
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_BUSINESS')")
     */
    public function delete(Request $request, Offer $offer): Response
    {
        if ($this->isCsrfTokenValid('delete' . $offer->getid(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($offer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('offer_list');
    }
}
