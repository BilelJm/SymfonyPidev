<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProgController extends AbstractController
{
    /**
     * @Route("/prog", name="prog")
     */
    public function index(): Response
    {
        return $this->render('prog/index.html.twig', [
            'controller_name' => 'ProgController',
        ]);
    }
    /**
     * @Route("/programmes", name="programmes")
     */
    public function programmes(): Response
    {
        return $this->render('programme/programmes.html.twig', [
            'controller_name' => 'ProgController',
        ]);
    }
    /**
     * @Route("/about", name="about")
     */
    public function about(): Response
    {
        return $this->render('prog/about.html.twig', [
            'controller_name' => 'ProgController',
        ]);
    }
    /**
     * @Route("/contact", name="contact")
     */
    public function contact(): Response
    {
        return $this->render('prog/contact.html.twig', [
            'controller_name' => 'ProgController',
        ]);
    }
}
