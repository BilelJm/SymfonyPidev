<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/register", name="security_register")
     */
    public function Register(Request $request , UserPasswordEncoderInterface $encoder, \Swift_Mailer $mailer): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $form->add('Inscription',SubmitType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            //encoder le mot de passe
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);

            //generer le token
            $user->setActivationToken(md5(uniqid()));


            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->addFlash('success',
            "Votre compte a bien été créé ! Vouz pouvez maintenant vous connecter ! ");

            $message =(new \Swift_Message('Nouveau compte'))

                ->setFrom('votre@adresse.fr')

                ->setTo($user->getEmail())

                ->setBody(
                    $this->renderView(
                        'emails/activation.html.twig',['token'=>$user->getActivationToken()]
                    ),
                    'text/html'
                )
            ;
            $mailer->send($message);

            return $this->redirectToRoute("app_login");

        }
        return $this->render('User/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/activation/{token}", name="activation")
     */
    public function activation($token, UserRepository $users){
        // nlawjou aala user aandou token f DB
        $user = $users->findOneBy(['activation_token'=>$token]);

        if(!$user){

            throw  $this->createNotFoundException('Cet utilisateur n\'existe pas');
        }
        $user->setActivationToken(null);
        $em= $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();;

        $this->addFlash('message', 'Compte activé avec succes ');

        return $this->redirectToRoute('prog');
    }



}

