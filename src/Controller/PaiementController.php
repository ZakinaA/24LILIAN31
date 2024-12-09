<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Paiement;
use App\Entity\Maison;
use App\Form\PaiementType;
use App\Form\PaiementModifierType;
use Symfony\Component\HttpFoundation\Request;


class PaiementController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('paiement/index.html.twig', [
            'controller_name' => 'PaiementController',
        ]);
    }

    public function accueil(): Response
    {
        $annee = '2025';
        return $this->render('paiement/accueil.html.twig', ['pAnnee' => $annee,
       ]);	
    }	
    
    public function ajouter(ManagerRegistry $doctrine, Request $request){
    
		
        $paiement = new Paiement();
        $form = $this->createForm(PaiementType::class, $paiement);
        $form->handleRequest($request);
     
        if ($form->isSubmitted() && $form->isValid()) {
     
                $paiement = $form->getData();
     
                $entityManager = $doctrine->getManager();
                $entityManager->persist($paiement);
                $entityManager->flush();
     
            return $this->render('paiement/consulter.html.twig', ['paiement' => $paiement,]);
        }
        else
            {
                return $this->render('paiement/ajouter.html.twig', array('form' => $form->createView(),));
        }
            
    }

        public function consulterPaiement(ManagerRegistry $doctrine, int $id){

            $paiement= $doctrine->getRepository(Paiement::class)->find($id);
    
            if (!$paiement) {
                throw $this->createNotFoundException(
                'Aucun élève trouvé avec le numéro '.$id
                );
            }
    
            //return new Response('Paiement : '.$paiement->getNom());
            return $this->render('paiement/consulter.html.twig', [
                'paiement' => $paiement,]);
        }

        public function listerPaiement(ManagerRegistry $doctrine): Response
        {
            $pPaiement = $doctrine->getRepository(Paiement::class)->findAll();
        
            return $this->render('paiement/lister.html.twig', [
                'pPaiement' => $pPaiement,  // Passe la variable 'pPaiement' à Twig
            ]);
        }
        
        public function supprimerPaiement(ManagerRegistry $doctrine, int $id): Response
        {
            $paiement = $doctrine->getRepository(Paiement::class)->find($id);
    
            if (!$paiement) {
                throw $this->createNotFoundException('Aucun paiement trouvé avec l\'ID '.$id);
            }
    
            $entityManager = $doctrine->getManager();
            $entityManager->remove($paiement); 
            $entityManager->flush();
    
            return $this->redirectToRoute('app_lister');
        }


        public function modifierPaiement(ManagerRegistry $doctrine, $id, Request $request){
 
            //récupération de l'élève dont l'id est passé en paramètre
            $paiement = $doctrine->getRepository(Paiement::class)->find($id);
        
            if (!$paiement) {
                throw $this->createNotFoundException('Aucun paiement trouvé avec le numéro '.$id);
            }
            else
            {
                    $form = $this->createForm(PaiementModifierType::class, $paiement);
                    $form->handleRequest($request);
        
                    if ($form->isSubmitted() && $form->isValid()) {
        
                        $paiement = $form->getData();
                        $entityManager = $doctrine->getManager();
                        $entityManager->persist($paiement);
                        $entityManager->flush();
                        return $this->render('paiement/consulter.html.twig', ['paiement' => $paiement,]);
                }
                else{
                        return $this->render('paiement/ajouter.html.twig', array('form' => $form->createView(),));
                }
                }
                
        }
}
