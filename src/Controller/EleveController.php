<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Eleve;
use App\Entity\Maison;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Form\EleveType;
use App\Form\eleveModifierType;

class EleveController extends AbstractController
{
    #[Route('/eleve', name: 'app_eleve')]
    public function index(): Response
    {
        return $this->render('eleve/index.html.twig', [
            'controller_name' => 'EleveController',
        ]);
    }

    public function accueil(): Response
    {
        $annee = '2025';
        return $this->render('eleve/accueil.html.twig', [
            'pAnnee' => $annee,
        ]);
    }

    // Controller action for displaying the student's schedule
public function consulterEleve(ManagerRegistry $doctrine, int $id)
{
    $eleve = $doctrine->getRepository(Eleve::class)->find($id);
    
    if (!$eleve) {
        throw $this->createNotFoundException('Aucun étudiant trouvé avec le numéro ' . $id);
    }
    
    $inscriptions = $eleve->getInscriptions();
    
    // Initialize the schedule with empty values
    $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
    $heures = range(8, 20); // Example: 8 AM to 8 PM
    $planning = [];

    // Initialize empty schedule
    foreach ($jours as $jour) {
        foreach ($heures as $heure) {
            $planning[$jour][$heure] = null;
        }
    }

    // Populate the schedule with the enrolled courses
    foreach ($inscriptions as $inscription) {
        $jour = $inscription->getCours()->getJour()->getLibelle(); // Example: 'Lundi'
        $heureDebut = (int)$inscription->getCours()->getHeureDebut()->format('H');
        $heureFin = (int)$inscription->getCours()->getHeureFin()->format('H');
        
        $coursNom = $inscription->getCours()->getLibelle(); // Replace with actual method to get course name or other details
        
        for ($heure = $heureDebut; $heure < $heureFin; $heure++) {
            $planning[$jour][$heure] = $coursNom; // Store the course name or string
        }
    }

    return $this->render('eleve/consulter.html.twig', [
        'eleve' => $eleve,
        'planning' => $planning,
        'heures' => $heures,
        'jours' => $jours,
    ]);
}


    public function listereleve(ManagerRegistry $doctrine){

        $repository = $doctrine->getRepository(Eleve::class);

        $eleves= $repository->findAll();
        return $this->render('eleve/lister.html.twig', [
        'eEleves' => $eleves,]);	
    }

    public function modifiereleve(ManagerRegistry $doctrine, $id, Request $request)
{
    // Récupération de l'étudiant dont l'id est passé en paramètre
    $eleve = $doctrine->getRepository(Eleve::class)->find($id);

    if (!$eleve) {
        throw $this->createNotFoundException('Aucun étudiant trouvé avec le numéro '.$id);
    }

    $form = $this->createForm(EleveModifierType::class, $eleve);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $eleve = $form->getData();
        $entityManager = $doctrine->getManager(); // Corrected this line
        $entityManager->persist($eleve);
        $entityManager->flush();

        return $this->render('eleve/consulter.html.twig', ['eleve' => $eleve]);
    } else {
        return $this->render('eleve/ajouter.html.twig', ['form' => $form->createView()]);
    }
}



    public function ajouterEleve(ManagerRegistry $doctrine,Request $request){
        $eleve = new eleve();
	    $form = $this->createForm(EleveType::class, $eleve);
	    $form->handleRequest($request);
 
	if ($form->isSubmitted() && $form->isValid()) {
 
            $eleve = $form->getData();
 
            $entityManager = $doctrine->getManager();
            $entityManager->persist($eleve);
            $entityManager->flush();
 
	    return $this->render('eleve/consulter.html.twig', ['eleve' => $eleve,]);
	}
	else
        {
            return $this->render('eleve/ajouter.html.twig', array('form' => $form->createView(),));
	}
}


    public function supprimerEleve(ManagerRegistry $doctrine, int $id): Response
{
    $eleve = $doctrine->getRepository(Eleve::class)->find($id);

    if (!$eleve) {
        throw $this->createNotFoundException('Aucun eleve trouvé avec l ID '.$id);
    }

    $entityManager = $doctrine->getManager();
    $entityManager->remove($eleve); 
    $entityManager->flush();

    return $this->redirectToRoute('eleveLister');
}
          
    
}
