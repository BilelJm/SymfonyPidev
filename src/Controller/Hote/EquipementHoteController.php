<?php

namespace App\Controller\Hote;

use App\Entity\Equipement;
use App\Entity\Logement;
use App\Form\EquipementType;
use App\Repository\EquipementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("hote/equipement")
 */
class EquipementHoteController extends AbstractController
{

    /**
     * @Route("/", name="equipement_index", methods={"GET"})
     */
    public function index(EquipementRepository $equipementRepository): Response
    {
        $this->denyAccessUnLessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('hote/equipement/index.html.twig', [
            'equipements' => $equipementRepository->findAll()
        ]);
    }

    /**
     * @Route("/new", name="equipement_new", methods={"GET", "POST"})
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY'); //TODO:Change it to ROLE_HOTE

        $equipement = new Equipement();
        $form = $this->createForm(EquipementType::class, $equipement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($equipement);
            $entityManager->flush();

            return $this->redirectToRoute('equipement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('hote/equipement/new.html.twig', [
            'equipement' => $equipement,
            'form' => $form->createView(),//create view : la fonction qui permet de creer notre formulaire pour le twig :
        ]);
    }

    /**
     * @Route("/{id}", name="equipement_show", methods={"GET"})
     */
    public function show(Equipement $equipement): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY'); //TODO:Change it to ROLE_HOTE

        return $this->render('hote/equipement/show.html.twig', [
            'equipement' => $equipement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="equipement_edit", methods={"GET", "POST"})
     * @param Request $request
     * @param Equipement $equipement
     * @param EntityManagerInterface $entityManager
     * @param $equipement
     * @return Response
     */
    public function edit(Request $request, Equipement $equipement, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY'); //TODO:Change it to ROLE_HOTE

        $form = $this->createForm(EquipementType::class, $equipement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('equipement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('hote/equipement/edit.html.twig', [
            'equipement' => $equipement,
            'form' => $form->createView(),
        ]);
    }


}










