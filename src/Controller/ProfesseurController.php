<?php


namespace App\Controller;


use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ProfesseurType;
use App\Form\ProfesseurModifierType;
use App\Entity\Professeur;
use App\Entity\Cours;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class ProfesseurController extends AbstractController
{
    #[Route('/professeur', name: 'app_professeur')]
    public function index(): Response
    {
        return $this->render('professeur/index.html.twig', [
            'controller_name' => 'ProfesseurController',
        ]);
    }


    public function accueil(): Response
    {
        $annee = '2025';
        return $this->render('professeur/accueil.html.twig', [
            'pAnnee' => $annee,
        ]);
    }


    public function consulterProfesseur(ManagerRegistry $doctrine, int $id)
    {
        $professeur = $doctrine->getRepository(Professeur::class)->find($id);
   
        if (!$professeur) {
            throw $this->createNotFoundException('Aucun professeur trouvé avec le numéro ' . $id);
        }
   
        $cours = $professeur->getCours();
   
        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
        $heures = range(14, 22); 
        $planning = [];
   
        foreach ($jours as $jour) {
            foreach ($heures as $heure) {
                $planning[$jour][$heure] = null;
            }
        }
   
        foreach ($cours as $cour) {
            $jour = $cour->getJour()->getLibelle(); 
            $heureDebut = (int)$cour->getHeureDebut()->format('H');
            $heureFin = (int)$cour->getHeureFin()->format('H');
   
            for ($heure = $heureDebut; $heure < $heureFin; $heure++) {
                $planning[$jour][$heure] = $cour->getLibelle();
            }
        }
   
        return $this->render('professeur/consulter.html.twig', [
            'professeur' => $professeur,
            'planning' => $planning,
            'heures' => $heures,
            'jours' => $jours,
        ]);
    }


    public function listerProfesseur(ManagerRegistry $doctrine)
    {
        $repository = $doctrine->getRepository(Professeur::class);
        $professeurs = $repository->findAll();
        return $this->render('professeur/lister.html.twig', [
            'pProfesseurs' => $professeurs,
        ]);
    }


    public function modifierProfesseur(ManagerRegistry $doctrine, $id, Request $request)
    {
        $professeur = $doctrine->getRepository(Professeur::class)->find($id);
   
        if (!$professeur) {
            throw $this->createNotFoundException('Aucun étudiant trouvé avec le numéro '.$id);
        }
   
        $form = $this->createForm(ProfesseurModifierType::class, $professeur);
        $form->handleRequest($request);
   
        if ($form->isSubmitted() && $form->isValid()) {
            $professeur = $form->getData();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($professeur);
            $entityManager->flush();
   
            return $this->render('professeur/consulter.html.twig', ['professeur' => $professeur]);
        } else {
            return $this->render('professeur/ajouter.html.twig', ['form' => $form->createView()]);
        }
    }


    public function ajouterProfesseur(ManagerRegistry $doctrine, Request $request)
    {
        $professeur = new Professeur();
        $form = $this->createForm(ProfesseurType::class, $professeur);
        $form->handleRequest($request);
   
        if ($form->isSubmitted() && $form->isValid()) {
            $professeur = $form->getData();
   
            $entityManager = $doctrine->getManager();
            $entityManager->persist($professeur);
            $entityManager->flush();
   
            return $this->render('professeur/consulter.html.twig', ['professeur' => $professeur]);
        } else {
            return $this->render('professeur/ajouter.html.twig', ['form' => $form->createView()]);
        }
    }

    public function supprimerProfesseur(ManagerRegistry $doctrine, $id)
    {
        $em = $doctrine->getManager(); 
   
        $professeur = $em->getRepository(Professeur::class)->find($id);
   
        if (!$professeur) {
            throw $this->createNotFoundException('Le professeur avec l\'ID ' . $id . ' n\'existe pas.');
        }
   
        $coursRepository = $em->getRepository(Cours::class);
        $cours = $coursRepository->findBy(['professeur' => $professeur]);
   
        foreach ($cours as $cour) {
            $cour->setProfesseur(null); 
            $em->persist($cour);
        }
   
        $em->remove($professeur);
        $em->flush();
   
        return $this->redirectToRoute('professeurLister');
    }
}


 

