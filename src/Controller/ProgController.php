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
}
