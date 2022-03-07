<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Comments;
use App\Form\CommentsType;
use App\Repository\AnnonceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Monolog\DateTimeImmutable;

use Symfony\Component\Validator\Constraints\DateTime;

class ProgController extends AbstractController
{
    /**
     * @Route("/prog", name="prog")
     */
    public function index(): Response
    {

        return $this->render('prog/indexann.html.twig', [
            'controller_name' => 'ProgController',
        ]);
    }


    /**
     * @Route("/annonces", name="annonces")
     */
    public function annonce(AnnonceRepository $annonceRepository): Response
    {
        $annonces = $annonceRepository ->findAll();
        return $this->render('annonce/annonces.html.twig', [
            'annonces' => $annonces,

        ]);
    }

    /**
     * @Route("/about", name="about")
     */
    public function about(): Response
    {
        return $this->render('prog/aboutann.html.twig', [
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
