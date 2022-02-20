<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Form\RegisterType;
use http\Client\Response;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/register", name="security_register ")
     */
    public function Register(Request $request , UserPasswordEncoderInterface $encoder): \Symfony\Component\HttpFoundation\Response
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $form->add('Inscription',SubmitType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

        }
        return $this->render('security/register.html.twig', [
            'form' => $form->createView()
        ]);
    }





}

