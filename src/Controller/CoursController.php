<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Cours;
use App\Entity\TypeCours;
use App\Entity\TypeInstrument;
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

        public function listerCours(ManagerRegistry $doctrine, Request $request)
{
    $repository = $doctrine->getRepository(Cours::class);
    
    $queryBuilder = $repository->createQueryBuilder('c');

    if ($request->query->get('typeCours')) {
        $queryBuilder->andWhere('c.typeCours = :typeCours')
                     ->setParameter('typeCours', $request->query->get('typeCours'));
    }

    if ($request->query->get('typeInstrument')) {
        $queryBuilder->andWhere('c.typeInstrument = :typeInstrument')
                     ->setParameter('typeInstrument', $request->query->get('typeInstrument'));
    }

    $cours = $queryBuilder->getQuery()->getResult();

    return $this->render('cours/lister.html.twig', [
        'pCours' => $cours,
        'typeCours' => $doctrine->getRepository(TypeCours::class)->findAll(),
        'typeInstruments' => $doctrine->getRepository(TypeInstrument::class)->findAll()
    ]);
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
                        return $this->render('cours/modifier.html.twig', array('form' => $form->createView(),));
                }
                }
                
        }
}
