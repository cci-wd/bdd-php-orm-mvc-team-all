<?php

namespace App\Controller;

use App\Entity\Business;
use App\Entity\Offer;
use App\Form\OffersType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/offres")
 */
class OfferController extends AbstractController
{
    /**
     * @Route("/", name="offers_index", methods={"GET"})
     */
    public function index(): Response
    {
        $user = $this->getUser();

        $offers = $this->getDoctrine()
            ->getRepository(Offer::class)
            ->findAll();            

        return $this->render('offers/index.html.twig', [
            'offers' => $offers,
            'user' => $user,
            'meta_desc' => "Liste des offres d'emplois",
            'meta_title' => "Offres d'emplois",
        ]);
    }

    /**
     * @Route("/creer", name="offers_new", methods={"GET","POST"})
     */
    public function create(Request $request): Response
    {
        $user = $this->getUser();

        $offer = new Offer();
        $offer->setStatut(0);
        $offer->setBusiness($user->getBusiness());
        $offer->setPublishDate(new \DateTime());
        $form = $this->createForm(OffersType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($offer);
            $entityManager->flush();

            return $this->redirectToRoute('offers_index');
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
     * @Route("/{id}", name="offers_show", methods={"GET"})
     */
    public function show( $offer): Response
    {
        return $this->render('offers/show.html.twig', [
            'offer' => $offer,
            'meta_title' => "Voir l'annonce",
            'meta_desc' => "Voir une annonce",
        ]);
    }

    /**
     * @Route("/{id}/modifier", name="offers_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Offer $offer): Response
    {
        $offer->setStatut(0);
        $offer->setPublishDate(new \DateTime());
        $form = $this->createForm(OffersType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('offers_index');
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
     * @Route("/{id}", name="offers_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Offer $offer): Response
    {
        if ($this->isCsrfTokenValid('delete' . $offer->getid(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($offer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('offers_index');
    }
}
