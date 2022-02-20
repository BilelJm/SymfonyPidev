<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminAccountController extends AbstractController
{
    /**
     * @Route("/admin/dash", name="admin_users")
     */
    public function index(): Response
    {
        return $this->render('admin/user.html.twig', [
            'controller_name' => 'AdminAccountController',
        ]);
    }
}
