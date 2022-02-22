<?php

namespace App\Controller;

use App\Entity\PasswordUpdate;
use App\Entity\User;
use App\Form\PasswordUpdateType;
use App\Form\ProfileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait;
use Symfony\Component\Filesystem\Filesystem;

class  ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="profile")
     */
    public function edit(Request $request): Response
    {
        $user=$this->getUser();

        $form = $this->createForm(ProfileType::class, $user);

        $form->add('Modifier',SubmitType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $images=$form->get('picture')->getData();
            if ($images) {

                $originalFilename = pathinfo($images->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                //$safeFilename = transliterator_transliterate(' Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$images->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $images->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                //$product->setBrochureFilename($newFilename);
                $user->setPicture($newFilename);
            }



            $em= $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();



        }
        $this->addFlash(
            'success',
            "les données du profil ont été enregistrée"
        );
        return $this->render('profile/profile.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/updatepassword", name="updatepassword")
     */
    public function updatePassword(Request $request,UserPasswordEncoderInterface $encoder):Response
    {
        $passwordUpdate = new  PasswordUpdate();

        $user = $this->getUser();
        $form= $this->createForm(PasswordUpdateType::class, $passwordUpdate);

        $form->add('Modifier',SubmitType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            if(!password_verify($passwordUpdate->getOldPassword(), $user->getPassword()))
            {
            $form->get('oldPassword')->addError(new FormError("Le mot de passe que vous avez tapé n'est votre mot de passe actuel !"));
            }else{
                $newPassword = $passwordUpdate->getNewPassword();
                $password = $encoder->encodePassword($user, $newPassword);

                $user->setPassword($password);

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                return $this->redirectToRoute("profile");

            }

        }
        return $this->render('profile/updatePassword.html.twig',[
            'form'=>$form->createView()
        ]);

    }
}
