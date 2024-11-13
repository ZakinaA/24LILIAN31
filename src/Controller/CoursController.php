<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Cours;
use App\Entity\Maison;
use App\Form\CoursType;
use App\Form\CoursModifierType;
use Symfony\Component\HttpFoundation\Request;


class CoursController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('cours/index.html.twig', [
            'controller_name' => 'CoursController',
        ]);
    }

    public function accueil(): Response
    {
        $annee = '2025';
        return $this->render('cours/accueil.html.twig', ['pAnnee' => $annee,
       ]);	
    }	
    
    public function ajouter(ManagerRegistry $doctrine, Request $request){
    
		
        $cours = new Cours();
        $form = $this->createForm(CoursType::class, $cours);
        $form->handleRequest($request);
     
        if ($form->isSubmitted() && $form->isValid()) {
     
                $cours = $form->getData();
     
                $entityManager = $doctrine->getManager();
                $entityManager->persist($cours);
                $entityManager->flush();
     
            return $this->render('cours/consulter.html.twig', ['cours' => $cours,]);
        }
        else
            {
                return $this->render('cours/ajouter.html.twig', array('form' => $form->createView(),));
        }
            
    }

        public function consulterCours(ManagerRegistry $doctrine, int $id){

            $cours= $doctrine->getRepository(Cours::class)->find($id);
    
            if (!$cours) {
                throw $this->createNotFoundException(
                'Aucun élève trouvé avec le numéro '.$id
                );
            }
    
            //return new Response('Cours : '.$cours->getNom());
            return $this->render('cours/consulter.html.twig', [
                'cours' => $cours,]);
        }

        public function listerCours(ManagerRegistry $doctrine){

            $repository = $doctrine->getRepository(Cours::class);
    
            $cours= $repository->findAll();
            return $this->render('cours/lister.html.twig', [
                'pCours' => $cours,]);	
                
        }
       
        public function supprimerCours(ManagerRegistry $doctrine, int $id): Response
        {
            $cours = $doctrine->getRepository(Cours::class)->find($id);
    
            if (!$cours) {
                throw $this->createNotFoundException('Aucun cours trouvé avec l\'ID '.$id);
            }
    
            $entityManager = $doctrine->getManager();
            $entityManager->remove($cours); 
            $entityManager->flush();
    
            return $this->redirectToRoute('app_lister');
        }


        public function modifierCours(ManagerRegistry $doctrine, $id, Request $request){
 
            //récupération de l'élève dont l'id est passé en paramètre
            $cours = $doctrine->getRepository(Cours::class)->find($id);
        
            if (!$cours) {
                throw $this->createNotFoundException('Aucun cours trouvé avec le numéro '.$id);
            }
            else
            {
                    $form = $this->createForm(CoursModifierType::class, $cours);
                    $form->handleRequest($request);
        
                    if ($form->isSubmitted() && $form->isValid()) {
        
                        $cours = $form->getData();
                        $entityManager = $doctrine->getManager();
                        $entityManager->persist($cours);
                        $entityManager->flush();
                        return $this->render('cours/consulter.html.twig', ['cours' => $cours,]);
                }
                else{
                        return $this->render('cours/ajouter.html.twig', array('form' => $form->createView(),));
                }
                }
                
        }
}
