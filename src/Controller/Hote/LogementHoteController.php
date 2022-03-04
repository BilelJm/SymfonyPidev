<?php

namespace App\Controller\Hote;

use App\Entity\Logement;
use App\Repository\UserRepository;
use App\Filter\LogementSearch;
use App\Form\LogementActivationFormType;
use App\Form\LogementSearchType;
use App\Form\LogementType;
use App\Form\QrType;
use App\Repository\EquipementRepository;
use App\Repository\LogementRepository;
use App\Services\QrCodeGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * @Route("hote/logement")
 *
 */
class LogementHoteController extends AbstractController
{
    /**
     * @Route("/LogementAllJSON",name="LogementAllJSON")
     */

    public function LogementAllJSON(NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(Logement::class);
        $logement = $repository->findAll();
        $jsonContent = $Normalizer->normalize($logement, 'json', ['groups' => 'post:read']);
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/LogementAllByUserJSON/{idUser}",name="LogementAllByUserJSON")
     */

    public function LogementAllByUserJSON(NormalizerInterface $Normalizer, $idUser)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(Logement::class);
        $logement = $repository->findBy(['hote' => $idUser]);
        $jsonContent = $Normalizer->normalize($logement, 'json', ['groups' => 'post:read']);
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/LogementByIdJSON/{id}",name="LogementByIdJSON")
     */

    public function LogementByIdJSON(NormalizerInterface $Normalizer, $id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(Logement::class);
        $logement = $repository->find($id);
        $jsonContent = $Normalizer->normalize($logement, 'json', ['groups' => 'post:read']);
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/json_addlogement/{hote_id}/{titre}/{description}/{addresse}/{filename}/{equipement}",name="json_addlogement")
     */
    public function json_addlogement(NormalizerInterface $Normalizer, UserRepository $userRepository, EquipementRepository $repository, $hote_id, $titre, $description, $addresse, $filename, $equipement)
    {
        $em = $this->getDoctrine()->getManager();
        $logement = new Logement();
        $user = $userRepository->find($hote_id);
        $mm = $repository->find($equipement);
        $logement->setHote($user);
        $logement->setAddresse($addresse);
        $logement->setDescription($description);
        $logement->setFilename($filename);
        $logement->setTitre($titre);
        $logement->addEquipement($mm);
        $em->persist($logement);
        $em->flush();
        $jsonContent = $Normalizer->normalize($logement, 'json', ['groups' => 'post:read']);
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/json_updatelogement/{id}/{hote_id}/{titre}/{description}/{addresse}/{filename}/{equipement}",name="json_updatelogement")
     */
    public function json_updatelogement(NormalizerInterface $Normalizer, UserRepository $userRepository, EquipementRepository $repository, LogementRepository $logementrepository, $id, $hote_id, $titre, $description, $addresse, $filename, $equipement)
    {
        $em = $this->getDoctrine()->getManager();
        $logement = $logementrepository->find($id);
        $user = $userRepository->find($hote_id);
        $mm = $repository->find($equipement);
        $logement->setHote($user);
        $logement->setAddresse($addresse);
        $logement->setDescription($description);
        $logement->setFilename($filename);
        $logement->setTitre($titre);
        $logement->addEquipement($mm);
        $em->persist($logement);
        $em->flush();
        $jsonContent = $Normalizer->normalize($logement, 'json', ['groups' => 'post:read']);
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/json_deletelogement/{id}", name="json_deletelogement")
     */

    public function json_deletelogement($id, LogementRepository $repository, NormalizerInterface $Normalizer)
    {


        $em = $this->getDoctrine()->getManager();

        $logement = $em->getRepository(Logement::class)->find($id);

        if ($logement != null) {
            $em->remove($logement);
            $em->flush();

            $serielize = new Serializer([new ObjectNormalizer()]);
            $formatted = $serielize->normalize("logement supprimé avec success");
            return new Response(json_encode($formatted));
        }
        return new Response("id logement invalide");
    }

    /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security)//Injecttion de dépendence
    {
        $this->security = $security;
    }

    /**
     * @Route("/", name="logement_index", methods={"GET"})
     */
    public function index(LogementRepository $logementRepository, Request $request): Response // return type is http response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY'); //TODO:Change it to ROLE_HOTE

        $search = new LogementSearch();
        $form = $this->createForm(LogementSearchType::class, $search);
        $form->handleRequest($request);

        //Récuperer l'User authentifier
        $user = $this->security->getUser();
        //Requete pour affficher les logements par user connecter
        $logementsByUser = $logementRepository->findLogementByUser($user, $search);

        return $this->render('hote/logement/index.html.twig', [
            'logements' => $logementsByUser,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/new", name="logement_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, QrCodeGenerator $qrCodeGenerator): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY'); //TODO:Change it to ROLE_HOTE

        $logement = new Logement();
        $form = $this->createForm(LogementType::class, $logement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //1 récuperer l'user connecté
            $hote = $this->security->getUser();
            $logement->setHote($hote);

            $qrCodeGenerator->qrcode($logement);

            $entityManager->persist($logement);
            $entityManager->flush();

            return $this->redirectToRoute('logement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('hote/logement/new.html.twig', [
            'logement' => $logement,
            'form' => $form->createView(),//create view : la fonction qui permet de creer notre formulaire pour le twig :
        ]);
    }

    /**
     * @Route("/{id}", name="logement_show", methods={"GET"})
     */
    public function show(Logement $logement): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY'); //TODO:Change it to ROLE_HOTE

        return $this->render('hote/logement/show.html.twig', [
            'logement' => $logement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="logement_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Logement $logement, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY'); //TODO:Change it to ROLE_HOTE

        $form = $this->createForm(LogementType::class, $logement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('logement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('hote/logement/edit.html.twig', [
            'logement' => $logement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/active", name="logement_active", methods={"GET", "POST"})
     */
    public function active(Request $request, Logement $logement, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY'); //TODO:Change it to ROLE_HOTE

        $form = $this->createForm(LogementActivationFormType::class, $logement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            if ($logement->getIsActive() == true) {
                $this->addFlash('success', 'Logement activé avec succés!');

            } else if ($logement->getIsActive() == false) {
                $this->addFlash('danger', 'Logement descativé  avec succés!');

                }

            return $this->redirectToRoute('logement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('hote/logement/active.html.twig', [
            'logement' => $logement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="logement_delete", methods={"POST"})
     */
    public function delete(Request $request, Logement $logement, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY'); //TODO:Change it to ROLE_HOTE

        if ($this->isCsrfTokenValid('delete' . $logement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($logement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('logement_index', [], Response::HTTP_SEE_OTHER);
    }

}
