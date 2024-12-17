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
use App\Form\EleveModifierType;

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

    
#[Route('/gestionnaire/eleve/consulter/{id}', name: 'gestionnaireConsulterEleve')]
#[Route('/etudiant/eleve/consulter/{id}', name: 'eleveConsulterEleve')]
public function consulterEleve(ManagerRegistry $doctrine, int $id)
{
    $eleve = $doctrine->getRepository(Eleve::class)->find($id);
    
    if (!$eleve) {
        throw $this->createNotFoundException('Aucun étudiant trouvé avec le numéro ' . $id);
    }
    
    $inscriptions = $eleve->getInscriptions();
    
    $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
    $heures = range(8, 20);
    $planning = [];

    foreach ($jours as $jour) {
        foreach ($heures as $heure) {
            $planning[$jour][$heure] = null;
        }
    }

    foreach ($inscriptions as $inscription) {
        $cours = $inscription->getCours();
    
        if ($cours && $cours->getJour()) { 
            $jour = $cours->getJour()->getLibelle(); 
            $heureDebut = (int)$cours->getHeureDebut()->format('H');
            $heureFin = (int)$cours->getHeureFin()->format('H');
            
            $coursNom = $cours->getLibelle(); 
            
            for ($heure = $heureDebut; $heure < $heureFin; $heure++) {
                $planning[$jour][$heure] = $coursNom; 
            }
        } else {
        }
    }

    return $this->render('eleve/consulter.html.twig', [
        'eleve' => $eleve,
        'planning' => $planning,
        'heures' => $heures,
        'jours' => $jours,
    ]);
}


    #[Route('etudiant/eleve/lister', name: 'etudiantListerEleve')]
    public function listereleve(ManagerRegistry $doctrine){

        $repository = $doctrine->getRepository(Eleve::class);

        $eleves= $repository->findAll();
        return $this->render('eleve/lister.html.twig', [
        'eEleves' => $eleves,]);	
    }

    
    #[Route('/gestionnaire/eleve/modifier/{id}', name: 'gestionnaireModifierEleve')]
    public function modifiereleve(ManagerRegistry $doctrine, $id, Request $request): Response
    {
        $eleve = $doctrine->getRepository(Eleve::class)->find($id);

        if (!$eleve) {
            throw $this->createNotFoundException('Aucun étudiant trouvé avec le numéro ' . $id);
        }

        $form = $this->createForm(EleveModifierType::class, $eleve);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $form['cheminImage']->getData();

            if ($uploadedFile) {
                $destination = $this->getParameter('kernel.project_dir') . '/public/eleve';
                $newFilename = uniqid() . '.' . $uploadedFile->guessExtension();
                $uploadedFile->move($destination, $newFilename);

                $eleve->setCheminImage($newFilename);
            }

            $entityManager = $doctrine->getManager();
            $entityManager->persist($eleve);
            $entityManager->flush();

            return $this->redirectToRoute('gestionnaireListerEleve');
        }

        return $this->render('eleve/modifier.html.twig', [
            'form' => $form->createView(),
        ]);
    }




        
    #[Route('/gestionnaire/eleve/ajouter', name: 'gestionnaireAjouterEleve')]
    public function ajouterEleve(ManagerRegistry $doctrine, Request $request)
{
    $eleve = new Eleve();
    $form = $this->createForm(EleveType::class, $eleve);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $uploadedFile = $form['cheminImage']->getData();

        if ($uploadedFile) {
            $destination = $this->getParameter('kernel.project_dir') . '/public/eleve';
            $newFilename = uniqid() . '.' . $uploadedFile->guessExtension();
            $uploadedFile->move($destination, $newFilename);

            $eleve->setCheminImage($newFilename);
        }

        $entityManager = $doctrine->getManager();
        $entityManager->persist($eleve);
        $entityManager->flush();

        return $this->render('eleve/consulter.html.twig', ['eleve' => $eleve]);
    } else {
        return $this->render('eleve/ajouter.html.twig', ['form' => $form->createView()]);
    }
}

    
    #[Route('/gestionnaire/eleve/supprimer/{id}', name: 'gestionnaireSupprimerEleve')]
    public function supprimerEleve(ManagerRegistry $doctrine, int $id): Response
{
    $eleve = $doctrine->getRepository(Eleve::class)->find($id);

    if (!$eleve) {
        throw $this->createNotFoundException('Aucun eleve trouvé avec l ID '.$id);
    }

    $entityManager = $doctrine->getManager();
    $entityManager->remove($eleve); 
    $entityManager->flush();

    return $this->redirectToRoute('gestionnaireListerEleve');
}

#[Route('/gestionnaire/eleve/lister', name: 'gestionnaireListerEleve')]
public function listerEleveGestionnaire(ManagerRegistry $doctrine): Response
{
    $repository = $doctrine->getRepository(Eleve::class);
    $eleves = $repository->findAll();

    return $this->render('eleve/gestionnaireListerEleve.html.twig', [
        'eEleves' => $eleves,
    ]);
}









          
    
}
