<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ResetPassType;
use App\Repository\UserRepository;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Client\Provider\GithubClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginSecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
         if ($this->getUser()) {
            return $this->redirectToRoute('prog');
         }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('User/login.html.twig', ['last_username' => $lastUsername,
                                                                'hasError' => $error !==null]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/connect/github", name="github_connect")
     */
    public function connect(ClientRegistry $clientRegistry): RedirectResponse
    {
        /** @var GithubClient $client */
        $client = $clientRegistry->getClient('github');
        return  $client->redirect(['read:user', 'user:email']);
    }


    /**
     * @Route("/oubli-pass", name="app_forgotten_password")
     */
    public function oubliPass(Request $request, UserRepository $users, \Swift_Mailer $mailer, TokenGeneratorInterface $tokenGenerator):Response
    {
        $form = $this->createForm(ResetPassType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $donnees = $form->getData();

            $user = $users->findOneByEmail($donnees['email']);

            if($user == null){

                $this->addFlash('danger', 'Cette adresse e-mail est inconnue');

                return  $this->redirectToRoute('app_login');
            }

            $token = $tokenGenerator->generateToken();

            try{
                $user->setResetToken($token);
                $em= $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
            }catch (\Exception $e){
                $this->addFlash('warning',$e->getMessage());
                return $this->redirectToRoute('app_login');
            }

            $url = $this->generateUrl('app_forgotten_password', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);

            $message= (new \Swift_Message('Mot de passe oublié'))
                ->setFrom('addresse@email.fr')

                ->setTo($user->getEmail())

                ->setBody(
                    "Bonjour,<br><br>Une demande de réinitialisation de mot de passe a été effectuée pour WIN. 
Veuillez cliquer sur le lien suivant : " . $url,
                    'text/html'
                )
                ;
            $mailer->send($message);

            $this->addFlash('message', 'E-mail de réinitialisation du mot de passe envoyé !');

            return  $this->redirectToRoute('app_login');
        }

        return $this->render('User/forgotten_password.html.twig',['emailForm'=> $form->createView()]);
    }

    /**
     * @Route("/reset_pass/{token}", name="app_reset_password")
     */
    public function resetPassword(Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['reset_token' => $token]);

        if ($user == null) {
            $this->addFlash('danger', 'Token Inconnu');
            return $this->redirectToRoute('app_login');

        }

        if ($request->isMethod('Post')) {

            $user->setResetToken(null);

            $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }else{
            return $this->render('User/reset_password.html.twig',['token'=>$token]);
        }
    }


}
