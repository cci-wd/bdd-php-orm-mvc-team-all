<?php

namespace App\Controller;

//use App\Entity\Business;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BusinessController extends AbstractController
{
    /**
     * @Route("/edit-business", name="editbusiness")
     */
    public function editbusiness()
    {

        /*

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $task = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($task);
            $entityManager->flush();

        }*/

        return $this->render('business/editbusiness.html.twig', [
            'controller_name' => 'BusinessController',
            'meta_title' => 'CCI-LINK, votre site de rencontres professionnel au CFA',
            'meta_desc' => 'Description des metas'

        ]);
    }
}
