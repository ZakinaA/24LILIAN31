<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Accessoire;
use App\Entity\Maison;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Form\AccessoireType; 
use App\Form\AccessoireModifierType;
use Doctrine\ORM\EntityManagerInterface;

class AccessoireController extends AbstractController
{
    #[Route('/accessoire', name: 'app_accessoire')]
    public function index(): Response
    {
        return $this->render('accessoire/index.html.twig', [
            'controller_name' => 'AccessoireController',
        ]);
    }

    public function accueil(): Response
    {
        $annee = '2025';
        return $this->render('accessoire/accueil.html.twig', [
            'pAnnee' => $annee,
        ]);
    }

    public function consulterAccessoire(ManagerRegistry $doctrine, int $id)
    {
        $accessoire = $doctrine->getRepository(Accessoire::class)->find($id);
    
        if (!$accessoire) {
            throw $this->createNotFoundException('Aucun accessoire trouvé avec l id ' . $id);
        }
            
        return $this->render('accessoire/consulter.html.twig', [
            'accessoire' => $accessoire,
        ]);
    }

    public function listerAccessoire(ManagerRegistry $doctrine){

        $repository = $doctrine->getRepository(Accessoire::class);

        $accessoires= $repository->findAll();
        return $this->render('accessoire/lister.html.twig', [
        'pAccessoires' => $accessoires,]);	
    }

    public function modifierAccessoire(Request $request, ManagerRegistry $doctrine, int $id): Response
    {
        $accessoire = $doctrine->getRepository(Accessoire::class)->find($id);

        if (!$accessoire) {
            throw $this->createNotFoundException('Aucun accessoire trouvée avec l\'ID ' . $id);
        }

        $form = $this->createForm(AccessoireModifierType::class, $accessoire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->flush(); // Mettre à jour l'accessoire
            return $this->redirectToRoute('accessoireLister');
        }

        return $this->render('accessoire/modifier.html.twig', [
            'form' => $form->createView(),
            'accessoire' => $accessoire,
        ]);
    }


    public function ajouterAccessoire(ManagerRegistry $doctrine,Request $request){
        $accessoire = new accessoire();
	    $form = $this->createForm(AccessoireType::class, $accessoire);
	    $form->handleRequest($request);
 
	if ($form->isSubmitted() && $form->isValid()) {
 
            $accessoire = $form->getData();
 
            $entityManager = $doctrine->getManager();
            $entityManager->persist($accessoire);
            $entityManager->flush();
 
            $accessoires = $doctrine->getRepository(Accessoire::class)->findAll();
        return $this->render('accessoire/lister.html.twig', [
            'pAccessoires' => $accessoires,
        ]);
    } else {
        return $this->render('accessoire/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

public function supprimerAccessoire(ManagerRegistry $doctrine, int $id): Response
{
    $accessoire = $doctrine->getRepository(Accessoire::class)->find($id);

    if (!$accessoire) {
        throw $this->createNotFoundException('Aucun accessoire trouvé avec l ID '.$id);
    }

    $entityManager = $doctrine->getManager();
    $entityManager->remove($accessoire); 
    $entityManager->flush();

    return $this->redirectToRoute('accessoireLister');
}
}
