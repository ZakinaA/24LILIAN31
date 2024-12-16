<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
{
    try {
        // Logique normale
        $user = $this->getUser();
        if ($user === null || !$this->isGranted('ROLE_ELEVE')) {
            throw new AccessDeniedException('You do not have the required role');
        }

        // Si l'utilisateur a le bon rôle, continuer
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    } catch (AccessDeniedException $e) {
        // Gestion des erreurs d'accès : rediriger vers la page de login, ou afficher un message d'erreur personnalisé
        return $this->redirectToRoute('app_login');
    }
}

}