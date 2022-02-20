<?php

namespace App\Controller;

use App\Entity\Promotion;


use App\Form\PromotionFormType;
use App\Repository\PromotionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PromoController extends AbstractController
{

    /**
     * @Route("/promo", name="promo_index", methods={"GET"})
     */
    public function index(PromotionRepository $promotionRepository): Response

    {
        return $this->render('promotion/index.html.twig', [
            'promos' => $promotionRepository->findAll(),

        ]);
    }

    /**
     * @Route("/newPromo", name="promo_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $promo = new Promotion();
        $form = $this->createForm(PromotionFormType::class, $promo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($promo);
            $entityManager->flush();

            return $this->redirectToRoute('promotion_index');
        }

        return $this->render('promotion/new.html.twig', [
            'promos' => $promo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("promo_sh/{id}", name="promo_show", methods={"GET"})
     */
    public function show(Promotion $promo): Response
    {
        return $this->render('promotion/show.html.twig', [
            'promo' => $promo,
        ]);

    }

    /**
     * @Route("/{id}/edit_promo", name="promo_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Promotion $promo): Response
    {
        $form = $this->createForm(PromotionFormType::class, $promo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('promotion_index');
        }

        return $this->render('promotion/edit.html.twig', [
            'promo' => $promo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="promo_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Promotion $promo): Response
    {
        if ($this->isCsrfTokenValid('delete' . $promo->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($promo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('promotion_index');
    }

}
