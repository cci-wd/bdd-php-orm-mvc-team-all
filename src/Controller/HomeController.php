<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Entity\Student;
use App\Entity\Business;
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
        $totaloffers = $this->getDoctrine()->getRepository(Offer::class)->findAll();
        $totalcompagny = $this->getDoctrine()->getRepository(Business::class)->findAll();
        $totalstudents = $this->getDoctrine()->getRepository(Student::class)->findAll();

        return $this->render('pages/home.html.twig', [
            'offers' => $offers,
            'totaloffers' => $totaloffers,
            'totalcompagny' => $totalcompagny,
            'totalstudents' => $totalstudents,
            'controller_name' => 'HomeController',
            'meta_title' => 'CCI-LINK, votre site de rencontres professionnel au CFA',
            'meta_desc' => 'Description des metas'

        ]);
    }
}
