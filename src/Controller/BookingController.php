<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Form\BookingType;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/booking")
 */
class BookingController extends AbstractController
{
    /**
     * @Route("/", name="booking_index", methods={"GET"})
     */
    public function index(BookingRepository $bookingRepository): Response
    {
        return $this->render('booking/index.html.twig', [
            'booking' => $bookingRepository->findAll(),
        ]);
    }
    
     

    /**
     * @param Request $request
     * @return Response
     * @Route ("/searchAct",name="searchAct")
     */
    public function searchactivite(Request $request)
    {

        $repository = $this->getDoctrine()->getRepository(Booking::class);
        $requestString=$request->get('searchValue');
        $activite = $repository->findActbyNom($requestString);
        return $this->render('booking/index.html.twig' ,[
            "booking"=>$activite
        ]);
    }





    /**
     * @Route("/new", name="booking_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($booking);
            $entityManager->flush();

            return $this->redirectToRoute('booking_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('booking/new.html.twig', [
            'booking' => $booking,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="booking_show", methods={"GET"})
     */
    public function show(Booking $booking): Response
    {
        return $this->render('booking/show.html.twig', [
            'booking' => $booking,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="booking_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Booking $booking, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Booking1Type::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('booking_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('booking/edit.html.twig', [
            'booking' => $booking,
            'form' => $form->createView(),
        ]);
    }


  
    /**
 * @Route("/TrierParActb", name="TrierParActAscb", methods={"GET"})
 */
public function TrierParPrix(Request $request): Response
{
    $repository = $this->getDoctrine()->getRepository(Booking::class);
    $act = $repository->findByAct();
    return $this->render('booking/index.html.twig', [
        'booking' => $act,
    ]);
}



/**
 * @Route("/TrierParAct2", name="TrierParAct", methods={"GET"})
 */
public function TrierParCentreDesc(Request $request): Response
{
    $repository = $this->getDoctrine()->getRepository(Booking::class);
    $act = $repository->findByAct2();
    return $this->render('booking/index.html.twig', [
        'booking' => $act,
    ]);
}

    /**
     * @Route("/{id}", name="booking_delete", methods={"POST"})
     */
    public function delete(Request $request, Booking $booking, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$booking->getId(), $request->request->get('_token'))) {
            $entityManager->remove($booking);
            $entityManager->flush();
        }

        return $this->redirectToRoute('booking_index', [], Response::HTTP_SEE_OTHER);
    }
    
    
}
