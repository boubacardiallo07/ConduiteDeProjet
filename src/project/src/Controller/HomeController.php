<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/" ,name="app_home",methods={"GET"})
     */
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        return $this->render('/base.html.twig');
        // return $this->redirectToRoute("signup");
    }
}
