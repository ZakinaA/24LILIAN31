<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Cours;
use App\Repository\CoursRepository; 
use App\Entity\TypeCours;
use App\Entity\TypeInstrument;
use App\Form\CoursType;
use App\Form\CoursModifierType;
use Symfony\Component\HttpFoundation\Request;

class CoursController extends AbstractController
{
    private $coursRepository;

    public function __construct(CoursRepository $coursRepository)
    {
        $this->coursRepository = $coursRepository;
    }

    public function index(): Response
    {
        return $this->render('cours/index.html.twig', [
            'controller_name' => 'CoursController',
        ]);
    }

    #[Route(path: '/edt-cours', name: 'edt-cours')]


public function emploiDuTemps(): Response
{
    $heures = range(8, 20);

    $cours = $this->coursRepository->findAll();
    dump($cours); 

    $planning = $this->organiserPlanning($cours);

    return $this->render('cours/edt.html.twig', [
        'heures' => $heures,  
        'pCours' => $planning,
        'jours' => ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
    ]);
}



private function organiserPlanning($cours)
{
    $planning = [];
    $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
    $heures = range(8, 20);

    foreach ($jours as $jour) {
        foreach ($heures as $heure) {
            $planning[$jour][$heure] = [];  
        }
    }

    foreach ($cours as $coursItem) {
        $jour = $coursItem->getJour();
        if ($jour instanceof \App\Entity\Jour) {
            $jour = $jour->getLibelle(); 
        }

        $heure = $coursItem->getHeureDebut();
        if ($heure instanceof \DateTime) {
            $heure = $heure->format('H'); 
        }

        if (isset($planning[$jour][$heure])) {
            $planning[$jour][$heure][] = $coursItem;  
        }
    }

    dump($planning);  

    return $planning;
}


    #[Route('/gestionnaire/cours/ajouter', name: 'gestionnaireCoursAjouter')]
    public function ajouter(ManagerRegistry $doctrine, Request $request)
    {
        $cours = new Cours();
        $form = $this->createForm(CoursType::class, $cours);
        $form->handleRequest($request);
     
        if ($form->isSubmitted() && $form->isValid()) {
            $cours = $form->getData();
     
            $entityManager = $doctrine->getManager();
            $entityManager->persist($cours);
            $entityManager->flush();
     
            return $this->render('cours/consulter.html.twig', ['cours' => $cours]);
        } else {
            return $this->render('cours/ajouter.html.twig', ['form' => $form->createView()]);
        }
    }

    
    #[Route('/gestionnaire/cours/consulter/{id}', name: 'gestionnaireCoursConsulter')]
    public function consulterCours(ManagerRegistry $doctrine, int $id)
    {
        $cours = $doctrine->getRepository(Cours::class)->find($id);
    
        if (!$cours) {
            throw $this->createNotFoundException('Aucun cours trouvé avec l\'ID ' . $id);
        }
    
        return $this->render('cours/consulter.html.twig', ['cours' => $cours]);
    }

    
    #[Route('/gestionnaire/cours/lister', name: 'gestionnaireCoursLister')]
    #[Route('/etudiant/cours/lister', name: 'eleveCoursLister')]
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
            'typeInstruments' => $doctrine->getRepository(TypeInstrument::class)->findAll(),
        ]);
    }

    
    #[Route('/gestionnaire/cours/supprimer/{id}', name: 'gestionnaireCoursSupprimer')]
    public function supprimerCours(ManagerRegistry $doctrine, int $id): Response
    {
        $cours = $doctrine->getRepository(Cours::class)->find($id);
    
        if (!$cours) {
            throw $this->createNotFoundException('Aucun cours trouvé avec l\'ID ' . $id);
        }
    
        $entityManager = $doctrine->getManager();
        $entityManager->remove($cours); 
        $entityManager->flush();
    
        return $this->redirectToRoute('gestionnaireCoursLister');
    }

    
    #[Route('/gestionnaire/cours/modifier/{id}', name: 'gestionnaireCoursModifier')]
    public function modifierCours(ManagerRegistry $doctrine, $id, Request $request)
    {
        $cours = $doctrine->getRepository(Cours::class)->find($id);
        
        if (!$cours) {
            throw $this->createNotFoundException('Aucun cours trouvé avec le numéro ' . $id);
        } else {
            $form = $this->createForm(CoursModifierType::class, $cours);
            $form->handleRequest($request);
        
            if ($form->isSubmitted() && $form->isValid()) {
                $cours = $form->getData();
                $entityManager = $doctrine->getManager();
                $entityManager->persist($cours);
                $entityManager->flush();
                return $this->render('cours/consulter.html.twig', ['cours' => $cours]);
            } else {
                return $this->render('cours/modifier.html.twig', ['form' => $form->createView()]);
            }
        }
    }
}
