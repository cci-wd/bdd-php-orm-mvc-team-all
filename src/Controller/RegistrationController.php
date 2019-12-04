<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register/{token}", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, User $user): Response
    {
        // $user = $this->getDoctrine()
        //     ->getRepository(User::class)
        //     ->find();

        $form = $this->createForm(RegistrationFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                $user
                    ->setPassword(
                        $passwordEncoder->encodePassword(
                            $user,
                            $form->get('password')->getData()
                        )
                    )
                    ->setStatus('1')
                    ->setToken(null)
                ;
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
