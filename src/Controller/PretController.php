<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PretController extends AbstractController
{
    #[Route('/pret', name: 'app_pret')]
    public function index(): Response
    {
        return $this->render('pret/index.html.twig', [
            'controller_name' => 'PretController',
        ]);
    }
}
