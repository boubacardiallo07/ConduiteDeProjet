<?php

namespace App\Controller;

use App\Form\UserRegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    public const LAST_EMAIL = 'app_login_form_last_email';

    /**
     * @Route("/registrer",name="app_registrer",methods={"GET", "POST"})
     */
    public function registrer(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $userPasswor): Response
    {
        $form = $this->createForm(UserRegistrationFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $plainPassword = $form['plainPassword']->getData();
            $user->setPassword($userPasswor->encodePassword($user, $plainPassword));
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'User successfully created');
            return $this->redirectToRoute('app_home');
        }
        return $this->render('security/register.html.twig', ['registrationForm' => $form->createView()]);
    }
    /**
     * @Route("/login", name="app_login",methods={"GET", "POST"} )
     */
    public function login(): Response
    {
        return $this->render('security/logIn.html.twig');
    }
    /**
     * @Route("/logout", name="app_logout",methods={"GET"})
     */
    public function logout()
    {
    }
}
