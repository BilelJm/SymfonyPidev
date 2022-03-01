<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserupdateType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminAccountController extends AbstractController
{


    /**
     * @Route("/admin/dash", name="admin_users")
     */
    public function listUser(): Response
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('admin/user.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/admin/dash", name="admin_dash")
     */
    public function index(): Response
    {

        return $this->render('admin/user.html.twig', [

        ]);
    }


    /**
     * @Route("/admin/updateuser/{id}", name="updateuser")
     */

    public  function  update(Request $request, $id){

    $user = $this->getDoctrine()->getRepository(User::class)->find($id);
    $form = $this->createForm(UserupdateType::class, $user);
    $form->add('Modifier', SubmitType::class);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()){
        $em= $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute("admin_users");
    }
    return  $this->render("admin/userupdate.html.twig",[
        'form'=>$form->createView()
    ]);
    }


    /**
     * @Route("/admin/delete/{id}", name="deleteUser")
     */
    public function delete($id){
        $user= $this->getDoctrine()->getRepository(User::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute("admin_users");
    }
}
