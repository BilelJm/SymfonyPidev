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
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
/**
 * @Route("hote/equipement")
 */
class EquipementHoteController extends AbstractController
{
    /**
     * @Route("/EquipementAllJSON",name="EquipementAllJSON")
     */

    public function EquipementAllJSON(NormalizerInterface  $Normalizer)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(Equipement::class);
        $equipements = $repository->findAll();
        $jsonContent = $Normalizer->normalize($equipements, 'json', ['groups' => 'post:read']);
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/EquipementByIdJSON/{id}",name="EquipementByIdJSON")
     */

    public function EquipementByIdJSON(NormalizerInterface  $Normalizer,$id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(Equipement::class);
        $equipements = $repository->find($id);
        $jsonContent = $Normalizer->normalize($equipements, 'json', ['groups' => 'post:read']);
        return new Response(json_encode($jsonContent));
    }
    /**
     * @Route("/json_addequpement/{nom}",name="json_addequpement")
     */
    public function json_addequpement(NormalizerInterface $Normalizer,$nom)
    {
        $em = $this->getDoctrine()->getManager();
        $equipement = new Equipement();
        $equipement->setNom($nom) ;
        $em->persist($equipement);
        $em->flush();
        $jsonContent = $Normalizer->normalize($equipement, 'json', ['groups' => 'post:read']);
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/json_updateequipement/{id}/{nom}",name="json_updateequipement")
     */
    public function json_updateequipement(NormalizerInterface $Normalizer,EquipementRepository $repository,$id,$nom)
    {
        $em = $this->getDoctrine()->getManager();
        $equipement = $repository->find($id);
        $equipement->setNom($nom);
        $em->persist($equipement);
        $em->flush();
        $jsonContent = $Normalizer->normalize($equipement, 'json', ['groups' => 'post:read']);
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/json_deleteequipement/{id}", name="json_deleteequipement")
     */

    public  function json_deleteequipement($id,EquipementRepository $repository,NormalizerInterface $Normalizer){


        $em = $this->getDoctrine()->getManager();

        $equipement = $em->getRepository(Equipement::class)->find($id);

        if($equipement!=null){
            $em->remove($equipement);
            $em->flush();

            $serielize = new Serializer([new ObjectNormalizer()]);
            $formatted = $serielize->normalize("equipement supprimé avec success");
            return new Response(json_encode($formatted));
        }
        return new Response("id equipement invalide");
    }
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










