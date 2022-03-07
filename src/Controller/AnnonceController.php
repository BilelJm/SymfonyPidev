<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Comments;
use App\Entity\Images;
use App\Entity\Prosearch;
use App\Form\AnnonceType;
use App\Form\CommentsType;
use App\Form\ProSearchType;
use App\Form\SearchType;
use App\Repository\AnnonceRepository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Monolog\DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;


class AnnonceController extends AbstractController
{
    /**
     * @Route("/annonce", name="annonce_index", methods={"GET"})
     */
    public function index(AnnonceRepository $annonceRepository,Request $request,Annonce $annonce): Response
    {
        $annonce=new Annonce();
        $form=$this->createForm(CommentsType::class,$annonce);
        $form->add('chercher',SubmitType::class);

          $form->handelRequest($request);

          if ($form->isSubmitted()&&$form-> isValid()){
              $term = $annonce->getTitre();
              $allannonces = $annonceRepository->recherche($term);
          }
          else{
              $annonces = $annonceRepository ->findAll();
          }
        return $this->render('annonce/indexann.html.twig', [
            'annonces' => $annonces,
        ]);


    }


    /**
     * @Route("/annonce/new", name="annonce_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $annonce = new Annonce();
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->add('Enregistrer',SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //on recupere les images transmises
            $images =$form ->get('images')->getData();
            foreach ($images as $image){
                $fichier = md5(uniqid()).'.'.$image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                //stock image dans la BD$
                $img = new Images();
                $img->setName($fichier);
                $annonce->addImage($img);

            }

            $entityManager->persist($annonce);
            $entityManager->flush();

            return $this->redirectToRoute('annonce_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('annonce/new.html.twig', [
            'annonce' => $annonce,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/annonce/{id}", name="annonce_show", methods={"GET"})
     */
    public function show(Annonce $annonce): Response
    {
        return $this->render('annonce/show.html.twig', [
            'annonce' => $annonce,
        ]);
    }
    /**
     * @Route("/annonce_comment/{id}", name="annonce_comment")
     */
    public function comment(Annonce $annonce,Request $request): Response

    {
        $comment=new Comments();
        $commentForm=$this->createForm(CommentsType::class,$comment);
        $commentForm->add('envoyer',SubmitType::class);
        $commentForm->handleRequest($request);


        if($commentForm->isSubmitted() && $commentForm->isValid()){


            $comment->setAnnonces($annonce);
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();
            return $this->redirectToRoute('annonces');

        }
        return $this->render('prog/comment.html.twig', [
            'annonce' => $annonce,
            'commentForm'=> $commentForm->createView()
        ]);
    }

    /**
     * @Route("/annonce/{id}/edit", name="annonce_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Annonce $annonce, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('annonce_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('annonce/edit.html.twig', [
            'annonce' => $annonce,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/annonce/{id}", name="annonce_delete", methods={"POST"})
     */
    public function delete(Request $request, Annonce $annonce, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$annonce->getId(), $request->request->get('_token'))) {
            $entityManager->remove($annonce);
            $entityManager->flush();
        }

        return $this->redirectToRoute('annonce_index', [], Response::HTTP_SEE_OTHER);
    }



}
