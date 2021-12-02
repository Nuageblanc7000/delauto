<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * permet la connection de l'user
     * @Route("/login", name="login")
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
  
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * permet la déconnexion du user
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('une erreur est survenu');
    }
}
