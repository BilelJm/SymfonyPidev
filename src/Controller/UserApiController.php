<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class UserApiController extends AbstractController
{
    /**
     * @Route("/user/signup", name="user_signup")
     */
    public function signupAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {

        $username = $request->query->get("username");
        $email = $request->query->get("email");
        $firstName = $request->query->get("firstname");
        $lastName = $request->query->get("lastname");

        $password = $request->query->get("password");


        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return new Response("email invalid");
        }
        $user = new User();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setPassword($passwordEncoder->encodePassword(
            $user,
            $password));


        try {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return new JsonResponse("Account is created", 200);
        } catch (\Exception $ex) {

            return new Response("execption" . $ex->getMessage());
        }


    }

    /**
     * @Route("/user/signin", name="user_signin")
     */
    public function signin(Request $request)
    {
        $email = $request->query->get("email");
        $password = $request->query->get("password");

        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository(User::class)->findOneBy(['email' => $email]);

        if ($user)
        {

            if (password_verify($password, $user->getPassword()))
            {
                $serializer = new Serializer([new ObjectNormalizer()]);
                $formatted = $serializer->normalize($user);
                return new JsonResponse($formatted);
            } else
            {
                return new Response("password not found");
            }}

        else{
                return new Response("user not found");
            }

        }

    /**
     * @Route("/user/editUser", name="user_gesttion_profile")
     */
    //public function editUser(Request)



}
