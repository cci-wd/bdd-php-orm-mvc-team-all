<?php

namespace App\Controller;

use App\Entity\Offers;
use App\Form\OffersType;
use App\Entity\Businesses;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Validation;

/**
 * @Route("/offers")
 */
class OffersController extends AbstractController
{
    /**
     * @Route("/", name="offers_index", methods={"GET"})
     */
    public function index(): Response
    {
        $user = $this->getUser();
        $userId = $user->getId();

        $businesses = $this->getDoctrine()
            ->getRepository(Businesses::class)
            ->findBy(['users' => $userId]);

        $businessesId = $businesses[0]->getId();

        $offers = $this->getDoctrine()
            ->getRepository(Offers::class)
            ->findBy(['businesses' => $businessesId]);            

        return $this->render('offers/index.html.twig', [
            'offers' => $offers,
            'user' => $user,
            'meta_desc' => "Liste des offres d'emplois",
            'meta_title' => "Offres d'emplois"
        ]);
    }

    /**
     * @Route("/new", name="offers_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = $this->getUser();
        $userId = $user->getId();
        
        $businesses = $this->getDoctrine()
            ->getRepository(Businesses::class)
            ->findBy(['users' => $userId]);

        $offer = new Offers();
        $offer->setStatut(0);
        $offer->setBusinesses($businesses[0]);
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
            'form_desc' => ""
            /* 'errors' => $errors */
        ]);

    }

    /**
     * @Route("/{id}", name="offers_show", methods={"GET"})
     */
    public function show(Offers $offer): Response
    {
        return $this->render('offers/show.html.twig', [
            'offer' => $offer,
            'meta_title' => "Voir l'annonce",
            'meta_desc' => "Voir une annonce"
        ]);
    }

    /**
     * @Route("/{id}/edit", name="offers_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Offers $offer): Response
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
    public function delete(Request $request, Offers $offer): Response
    {
        if ($this->isCsrfTokenValid('delete'.$offer->getid(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($offer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('offers_index');
    }    
}
