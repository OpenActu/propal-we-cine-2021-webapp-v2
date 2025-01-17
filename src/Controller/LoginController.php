<?php

namespace App\Controller;

use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    #[Route('/connexion', name: 'app_login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render('login/index.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error'         => $authenticationUtils->getLastAuthenticationError(),
        ]);
    }

    #[Route('/', name: 'app_homepage')]
    public function homepage(AuthenticationUtils $authenticationUtils): Response
    {
        return $this->redirectToRoute('movie_genre_index');
    }

    #[Route('/deconnexion', name: 'app_logout', methods:['GET','POST'])]
    public function logout(): void
    {
    }
}
