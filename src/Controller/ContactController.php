<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request , \Swift_Mailer $mailer): Response
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $contactFormData = $form->getData();

        $message = (new \Swift_Message('You Got Mail!'))
            ->setFrom($contactFormData['email'])

            ->setTo('28401mansurahails@randomail.io')

            ->setBody(
                 $contactFormData['message'],
                 'text/plain'
                       );

          $mailer->send($message);

         return $this->redirectToRoute('contact');

        }
        return $this->render('emails/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
