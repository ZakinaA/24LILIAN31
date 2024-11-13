<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Professeur;
use App\Entity\Maison;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ProfesseurType;
use App\Form\ProfesseurModifierType;

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

    public function consulterProfesseur(ManagerRegistry $doctrine, int $id){

		$professeur= $doctrine->getRepository(Professeur::class)->find($id);

		if (!$professeur) {
			throw $this->createNotFoundException(
            'Aucun professeur trouvé avec le numéro '.$id
			);
		}

		//return new Response('Professeur : '.$professeur->getNom());
		return $this->render('professeur/consulter.html.twig', [
            'professeur' => $professeur,]);
	}

    public function listerProfesseur(ManagerRegistry $doctrine){

        $repository = $doctrine->getRepository(Professeur::class);

        $professeurs= $repository->findAll();
        return $this->render('professeur/lister.html.twig', [
        'pProfesseurs' => $professeurs,]);	
    }

    public function modifierProfesseur(ManagerRegistry $doctrine, $id, Request $request)
{
    // Récupération de l'étudiant dont l'id est passé en paramètre
    $professeur = $doctrine->getRepository(Professeur::class)->find($id);

    if (!$professeur) {
        throw $this->createNotFoundException('Aucun étudiant trouvé avec le numéro '.$id);
    }

    $form = $this->createForm(ProfesseurModifierType::class, $professeur);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $professeur = $form->getData();
        $entityManager = $doctrine->getManager(); // Corrected this line
        $entityManager->persist($professeur);
        $entityManager->flush();

        return $this->render('professeur/consulter.html.twig', ['professeur' => $professeur]);
    } else {
        return $this->render('professeur/ajouter.html.twig', ['form' => $form->createView()]);
    }
}



    public function ajouterProfesseur(ManagerRegistry $doctrine,Request $request){
        $professeur = new professeur();
	    $form = $this->createForm(ProfesseurType::class, $professeur);
	    $form->handleRequest($request);
 
	if ($form->isSubmitted() && $form->isValid()) {
 
            $professeur = $form->getData();
 
            $entityManager = $doctrine->getManager();
            $entityManager->persist($professeur);
            $entityManager->flush();
 
	    return $this->render('professeur/consulter.html.twig', ['professeur' => $professeur,]);
	}
	else
        {
            return $this->render('professeur/ajouter.html.twig', array('form' => $form->createView(),));
	}
}


    public function supprimerProfesseur(ManagerRegistry $doctrine, int $id): Response
{
    $professeur = $doctrine->getRepository(Professeur::class)->find($id);

    if (!$professeur) {
        throw $this->createNotFoundException('Aucun professeur trouvé avec l ID '.$id);
    }

    $entityManager = $doctrine->getManager();
    $entityManager->remove($professeur); 
    $entityManager->flush();

    return $this->redirectToRoute('professeurLister');
}
}
