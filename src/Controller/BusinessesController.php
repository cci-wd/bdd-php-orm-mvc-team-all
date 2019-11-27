<?php

namespace App\Controller;

use App\Entity\Businesses;
use App\Form\BusinessesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/businesses")
 */
class BusinessesController extends AbstractController
{
    /**
     * @Route("/", name="businesses_index", methods={"GET"})
     */
    public function index(): Response
    {
        $businesses = $this->getDoctrine()
            ->getRepository(Businesses::class)
            ->findAll();

        return $this->render('businesses/index.html.twig', [
            'businesses' => $businesses,
            'meta_title' => 'CCI-LINK, votre site de rencontres professionnel au CFA',
            'meta_desc' => 'Description des metas'
        ]);
    }

    /**
     * @Route("/new", name="businesses_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $business = new Businesses();
        $form = $this->createForm(BusinessesType::class, $business);
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
            'meta_desc' => 'Description des metas'
        ]);
    }

    /**
     * @Route("/{id}", name="businesses_show", methods={"GET"})
     */
    public function show(Businesses $business): Response
    {
        return $this->render('businesses/show.html.twig', [
            'business' => $business,
            'meta_title' => 'CCI-LINK, votre site de rencontres professionnel au CFA',
            'meta_desc' => 'Description des metas'
        ]);
    }

    /**
     * @Route("/{id}/edit", name="businesses_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Businesses $business): Response
    {
        $form = $this->createForm(BusinessesType::class, $business);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('businesses_index');
        }

        return $this->render('businesses/edit.html.twig', [
            'business' => $business,
            'form' => $form->createView(),
            'meta_title' => 'CCI-LINK, votre site de rencontres professionnel au CFA',
            'meta_desc' => 'Description des metas'
        ]);
    }

    /**
     * @Route("/{id}", name="businesses_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Businesses $business): Response
    {
        if ($this->isCsrfTokenValid('delete'.$business->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($business);
            $entityManager->flush();
        }

        return $this->redirectToRoute('businesses_index');
    }
}
