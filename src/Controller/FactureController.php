<?php

namespace App\Controller;

use App\Entity\Facture;
use App\Form\FactureType;
use App\Repository\FactureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * @Route("/facture")
 */
class FactureController extends AbstractController
{
    /**
     * @Route("/pdf", name="PDF", methods={"GET"})
     */
    public function pdf(FactureRepository $factureRepository): Response
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('facture/pdf.html.twig', [
            'facture' => $factureRepository-> findall(),
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();
        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("facture.pdf", [
            "facture" => true
        ]);
    }
    /**
     * @Route("/", name="facture_index", methods={"GET"})
     */
    public function index(FactureRepository $factureRepository): Response
    {
        return $this->render('facture/index.html.twig', [
            'facture' => $factureRepository->findAll(),
        ]);
    }
/**
     * @param Request $request
     * @return Response
     * @Route ("/searchfact",name="searchfact")
     */
    public function searchactivite(Request $request)
    {

        $repository = $this->getDoctrine()->getRepository(Facture::class);
        $requestString=$request->get('searchValue');
        $activite = $repository->findActbyNom($requestString);
        return $this->render('facture/index.html.twig' ,[
            "facture"=>$activite
        ]);
    }
    /**
     * @Route("/new", name="facture_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $facture = new Facture();
        $form = $this->createForm(FactureType::class, $facture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($facture);
            $entityManager->flush();

            return $this->redirectToRoute('facture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('facture/new.html.twig', [
            'facture' => $facture,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="facture_show", methods={"GET"})
     */
    public function show(Facture $facture): Response
    {
        return $this->render('facture/show.html.twig', [
            'facture' => $facture,
        ]);
    }
    


    /**
     * @Route("/{id}/edit", name="facture_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Facture $facture, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FactureType::class, $facture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('facture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('facture/edit.html.twig', [
            'facture' => $facture,
            'form' => $form->createView(),
        ]);
    }

  

    /**
     * @Route("/{id}", name="facture_delete", methods={"POST"})
     */
    public function delete(Request $request, Facture $facture, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$facture->getId(), $request->request->get('_token'))) {
            $entityManager->remove($facture);
            $entityManager->flush();
        }

        return $this->redirectToRoute('facture_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @param Request $request
     * @return Response
     * @Route ("/searchAction",name="searchAction")
     */
    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('q');
        $facture =  $em->getRepository('facture')->findEntitiesByString($requestString);
        if(!$facture) {
            $result['facture']['error'] = "facture introuvable :( ";
        } else {
            $result['facture'] = $this->getRealEntities($facture);
        }
        return new Response(json_encode($result));
    }
    public function getRealEntities($facture){
        foreach ($facture as $facture){
            $realEntities[$facture->getId()] = [$facture->getPhoto(),$facture->getTitle()];

        }
        return $realEntities;
    }
    
/**
 * @Route("/TrierParFacture", name="TrierParFactAsc", methods={"GET"})
 */
public function TrierParFinal(Request $req): Response
{
    $repository = $this->getDoctrine()->getRepository(Facture::class);
    $facture = $repository->findByFact();
    return $this->render('facture/index.html.twig', [
        'facture' => $facture,
    ]);
}

/**
 * @Route("/TrierParFAct2", name="TrierParFAct", methods={"GET"})
 */
public function TrierParCentreDesc(Request $request): Response
{
    $repository = $this->getDoctrine()->getRepository(Facture::class);
    $facture = $repository->findByAct2();
    return $this->render('facture/index.html.twig', [
        'facture' => $facture,
    ]);
}

}