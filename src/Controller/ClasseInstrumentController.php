<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClasseInstrumentController extends AbstractController
{
    #[Route('/classe/instrument', name: 'app_classe_instrument')]
    public function index(): Response
    {
        return $this->render('classe_instrument/index.html.twig', [
            'controller_name' => 'ClasseInstrumentController',
        ]);
    }
}
