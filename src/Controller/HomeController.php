<?php

namespace App\Controller;

use App\Entity\Offer;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $queryBuilder = $entityManager->createQueryBuilder();
        $offers = $queryBuilder
            ->select('offers')
            ->from(Offer::class, 'offers')
            ->orderBy('offers.publishDate', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();

        return $this->render('pages/home.html.twig', [
            'offers' => $offers,
            'controller_name' => 'HomeController',
            'meta_title' => 'CCI-LINK, votre site de rencontres professionnel au CFA',
            'meta_desc' => 'Description des metas'

        ]);
    }
}
