<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Modele;
use App\Entity\Maison;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ModeleType; 
use App\Form\ModeleModifierType;

class ModeleController extends AbstractController
{
    #[Route('/modele', name: 'app_modele')]
    public function index(): Response
    {
        return $this->render('modele/index.html.twig', [
            'controller_name' => 'ModeleController',
        ]);
    }

    public function accueil(): Response
    {
        $annee = '2025';
        return $this->render('modele/accueil.html.twig', [
            'pAnnee' => $annee,
        ]);
    }

    public function listerModele(ManagerRegistry $doctrine){

        $repository = $doctrine->getRepository(Modele::class);

        $modeles= $repository->findAll();
        return $this->render('modele/lister.html.twig', [
        'pModeles' => $modeles,]);	
    }

    public function modifierModele(ManagerRegistry $doctrine, $id, Request $request)
{
    $modele = $doctrine->getRepository(Modele::class)->find($id);

    if (!$modele) {
        throw $this->createNotFoundException('Aucun modele trouvé avec l\'ID '.$id);
    }

    $form = $this->createForm(ModeleModifierType::class, $modele);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $modele = $form->getData();

        $entityManager = $doctrine->getManager();
        $entityManager->persist($modele);
        $entityManager->flush();

        $modeles = $doctrine->getRepository(Modele::class)->findAll();

        return $this->render('modele/lister.html.twig', [
            'pModeles' => $modeles,
        ]);
    } else {
        return $this->render('modele/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}


    public function ajouterModele(ManagerRegistry $doctrine,Request $request){
        $modele = new modele();
	    $form = $this->createForm(ModeleType::class, $modele);
	    $form->handleRequest($request);
 
	if ($form->isSubmitted() && $form->isValid()) {
 
            $modele = $form->getData();
 
            $entityManager = $doctrine->getManager();
            $entityManager->persist($modele);
            $entityManager->flush();
 
            $modeles = $doctrine->getRepository(Modele::class)->findAll();
        return $this->render('modele/lister.html.twig', [
            'pModeles' => $modeles,
        ]);
    } else {
        return $this->render('modele/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}


    public function supprimerModele(ManagerRegistry $doctrine, int $id): Response
{
    $modele = $doctrine->getRepository(Modele::class)->find($id);

    if (!$modele) {
        throw $this->createNotFoundException('Aucun modele trouvé avec l ID '.$id);
    }

    $entityManager = $doctrine->getManager();
    $entityManager->remove($modele); 
    $entityManager->flush();

    return $this->redirectToRoute('modeleLister');
}
}
