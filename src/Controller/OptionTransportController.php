<?php

namespace App\Controller;

use App\Entity\OptionTransport;
use App\Form\OptionTransportType;
use App\Repository\OptionTransportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/option/transport")
 */
class OptionTransportController extends AbstractController
{
    /**
     * @Route("/", name="option_transport_index", methods={"GET"})
     */
    public function index(OptionTransportRepository $optionTransportRepository): Response
    {
        return $this->render('option_transport/index.html.twig', [
            'option_transports' => $optionTransportRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="option_transport_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $optionTransport = new OptionTransport();
        $form = $this->createForm(OptionTransportType::class, $optionTransport);
        $form->add("Enregistrer", SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($optionTransport);
            $entityManager->flush();

            return $this->redirectToRoute('option_transport_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('option_transport/new.html.twig', [
            'option_transport' => $optionTransport,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="option_transport_show", methods={"GET"})
     */
    public function show(OptionTransport $optionTransport): Response
    {
        return $this->render('option_transport/show.html.twig', [
            'option_transport' => $optionTransport,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="option_transport_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, OptionTransport $optionTransport, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OptionTransportType::class, $optionTransport);
        $form->add("Modifier", SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('option_transport_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('option_transport/edit.html.twig', [
            'option_transport' => $optionTransport,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="option_transport_delete", methods={"POST"})
     */
    public function delete(Request $request, OptionTransport $optionTransport, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$optionTransport->getId(), $request->request->get('_token'))) {
            $entityManager->remove($optionTransport);
            $entityManager->flush();
        }

        return $this->redirectToRoute('option_transport_index', [], Response::HTTP_SEE_OTHER);
    }
}
