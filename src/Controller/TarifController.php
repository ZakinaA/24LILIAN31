<?php

namespace App\Controller;

use App\Entity\Tarif;
use App\Repository\TarifRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TarifController extends AbstractController
{
    #[Route('/tarifs', name: 'tarif_lister')]
    public function lister(TarifRepository $tarifRepository): Response
    {
        $tarifs = $tarifRepository->findAll();

        return $this->render('tarif/lister.html.twig', [
            'tarifs' => $tarifs,
        ]);
    }

    #[Route('/tarif/{id}', name: 'tarif_consulter')]
    public function consulter(Tarif $tarif): Response
    {
        return $this->render('tarif/consulter.html.twig', [
            'tarif' => $tarif,
        ]);
    }
}
