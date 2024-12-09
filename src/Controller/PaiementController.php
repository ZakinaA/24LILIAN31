<?php

// src/Controller/PaiementController.php

namespace App\Controller;

use App\Entity\Paiement;
use App\Form\PaiementType;
use App\Repository\PaiementRepository;
use App\Repository\InscriptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaiementController extends AbstractController
{
  
     #[Route('/paiement/nouveau', name: 'paiement_new')]
    public function new(Request $request): Response
    {
        $paiement = new Paiement();
        $form = $this->createForm(PaiementType::class, $paiement);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($paiement);
            $entityManager->flush();
            
            return $this->redirectToRoute('paiement_list');
        }
        
        return $this->render('paiement/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    
    #[Route('/paiement/liste', name: 'paiement_list')]
    
    public function list(PaiementRepository $paiementRepository): Response
    {
        $paiements = $paiementRepository->findAll();
        
        return $this->render('paiement/list.html.twig', [
            'paiements' => $paiements,
        ]);
    }

    
    #[Route('/paiement/modifier/{id}', name: 'paiement_edit')]
    
    public function edit(Request $request, Paiement $paiement): Response
    {
        $form = $this->createForm(PaiementType::class, $paiement);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('paiement_list');
        }
        
        return $this->render('paiement/edit.html.twig', [
            'form' => $form->createView(),
            'paiement' => $paiement,
        ]);
    }

    
    #[Route('/paiement/supprimer/{id}', name: 'paiement_delete')]
    
    public function delete(PaiementRepository $paiementRepository, Paiement $paiement): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($paiement);
        $entityManager->flush();
        
        return $this->redirectToRoute('paiement_list');
    }
}

