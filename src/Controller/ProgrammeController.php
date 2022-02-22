<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Programme;
use App\Form\ProgrammeType;
use App\Repository\ProgrammeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/programme")
 */
class ProgrammeController extends AbstractController
{
    /**
     * @Route("/", name="programme_index", methods={"GET"})
     */
    public function index(ProgrammeRepository $programmeRepository): Response
    {
        return $this->render('programme/index.html.twig', [
            'programmes' => $programmeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="programme_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $programme = new Programme();
        $form = $this->createForm(ProgrammeType::class, $programme);
        $form->add("Enregistrer", SubmitType::class);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $images=$form->get('images')->getData();
            foreach ($images as $image) {

                $file = md5(uniqid()) . '.' . $image->guessExtension();

                $image->move($this->getParameter('images_directory'), $file);
                $img = new Image();
                $img->setNom($file);
                $programme->addImage($img);
            }


            $entityManager->persist($programme);
            $entityManager->flush();


            return $this->redirectToRoute('programme_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('programme/new.html.twig', [
            'programme' => $programme,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="programme_show", methods={"GET"})
     */
    public function show(Programme $programme): Response
    {
        return $this->render('programme/show.html.twig', [
            'programme' => $programme,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="programme_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Programme $programme, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProgrammeType::class, $programme);
        $form->add("Modifier", SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $images=$form->get('images')->getData();
            foreach ($images as $image) {

                $file = md5(uniqid()) . '.' . $image->guessExtension();

                $image->move($this->getParameter('images_directory'), $file);
                $img = new Image();
                $img->setNom($file);
                $programme->addImage($img);
            }
            $entityManager->flush();

            return $this->redirectToRoute('programme_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('programme/edit.html.twig', [
            'programme' => $programme,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="programme_delete", methods={"POST"})
     */
    public function delete(Request $request, Programme $programme, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$programme->getId(), $request->request->get('_token'))) {
            $entityManager->remove($programme);
            $entityManager->flush();
        }

        return $this->redirectToRoute('programme_index', [], Response::HTTP_SEE_OTHER);
    }
}
