<?php

namespace App\Controller;

use App\Repository\AnnonceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class CalendarController extends AbstractController
{
    /**
     * @Route("/calendar", name="calendar")
     */
    public function calendar(AnnonceRepository $annonceRepository): Response
    {
        $annonces=$annonceRepository->findAll();

        $tab=[];
        foreach ($annonces as $annonce){

            $tab[]=[
                'title' => $annonce->getTitre(),
                'date' => $annonce->getDate()->format('Y-m-d'),



            ];


        }

        $data= json_encode($tab);

        return $this->render('calendar/indexann.html.twig', compact('data')

        );
    }
}
