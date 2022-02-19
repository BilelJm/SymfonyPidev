<?php

namespace App\Controller;

use App\Entity\OptionGuide;
use App\Form\OptionGuideType;
use App\Repository\OptionGuideRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/option/guide")
 */
class OptionGuideController extends AbstractController
{
    /**
     * @Route("/", name="option_guide_index", methods={"GET"})
     */
    public function index(OptionGuideRepository $optionGuideRepository): Response
    {
        return $this->render('option_guide/index.html.twig', [
            'option_guides' => $optionGuideRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="option_guide_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $optionGuide = new OptionGuide();
        $form = $this->createForm(OptionGuideType::class, $optionGuide);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($optionGuide);
            $entityManager->flush();

            return $this->redirectToRoute('option_guide_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('option_guide/new.html.twig', [
            'option_guide' => $optionGuide,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="option_guide_show", methods={"GET"})
     */
    public function show(OptionGuide $optionGuide): Response
    {
        return $this->render('option_guide/show.html.twig', [
            'option_guide' => $optionGuide,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="option_guide_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, OptionGuide $optionGuide, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OptionGuideType::class, $optionGuide);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('option_guide_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('option_guide/edit.html.twig', [
            'option_guide' => $optionGuide,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="option_guide_delete", methods={"POST"})
     */
    public function delete(Request $request, OptionGuide $optionGuide, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$optionGuide->getId(), $request->request->get('_token'))) {
            $entityManager->remove($optionGuide);
            $entityManager->flush();
        }

        return $this->redirectToRoute('option_guide_index', [], Response::HTTP_SEE_OTHER);
    }
}
