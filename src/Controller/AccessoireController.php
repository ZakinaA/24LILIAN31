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

    #[Route('/gestionnaire/accessoire/consulter/{id}', name: 'accessoireConsulter')] 
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

    #[Route('/gestionnaire/accessoire/lister', name: 'accessoireLister')] 
    public function listerAccessoire(ManagerRegistry $doctrine){

        $repository = $doctrine->getRepository(Accessoire::class);

        $accessoires= $repository->findAll();
        return $this->render('accessoire/lister.html.twig', [
        'pAccessoires' => $accessoires,]);	
    }
    #[Route('/gestionnaire/accessoire/modifier/{id}', name: 'accessoireModifier')] 
    public function modifierAccessoire(Request $request, ManagerRegistry $doctrine, int $id): Response
    {
        $accessoire = $doctrine->getRepository(Accessoire::class)->find($id);
    
        if (!$accessoire) {
            throw $this->createNotFoundException('Aucun accessoire trouvé avec l\'ID ' . $id);
        }
    
        $form = $this->createForm(AccessoireModifierType::class, $accessoire);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('cheminImage')->getData();
    
            if ($imageFile) {
                $newFilename = uniqid().'.'.$imageFile->guessExtension();
    
                try {
                    $imageFile->move(
                        $this->getParameter('accessoire_images_directory'),
                        $newFilename
                    );
                    
                    // Mettre à jour le chemin de l'image seulement si un nouveau fichier est téléchargé
                    $accessoire->setCheminImage($newFilename);
                } catch (FileException $e) {
                    // Gérer l'exception si quelque chose se passe pendant le téléchargement
                    $this->addFlash('error', 'Une erreur est survenue lors du téléchargement de l\'image');
                }
            }
    
            $entityManager = $doctrine->getManager();
            $entityManager->flush();
    
            return $this->redirectToRoute('accessoireLister');
        }
    
        return $this->render('accessoire/modifier.html.twig', [
            'form' => $form->createView(),
            'accessoire' => $accessoire,
        ]);
    }

    #[Route('/gestionnaire/accessoire/ajouter', name: 'accessoireAjouter')]
    public function ajouterAccessoire(ManagerRegistry $doctrine, Request $request)
{
    $accessoire = new Accessoire();
    $form = $this->createForm(AccessoireType::class, $accessoire);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $imageFile = $form->get('cheminImage')->getData();

        if ($imageFile) {
            $newFilename = uniqid().'.'.$imageFile->guessExtension();

            try {
                $imageFile->move(
                    $this->getParameter('accessoire_images_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
            }

            $accessoire->setCheminImage($newFilename);
        }

        $entityManager = $doctrine->getManager();
        $entityManager->persist($accessoire);
        $entityManager->flush();

        return $this->redirectToRoute('accessoireLister');
    }

    return $this->render('accessoire/ajouter.html.twig', [
        'form' => $form->createView(),
    ]);
    }

    #[Route('/gestionnaire/accessoire/supprimer/{id}', name: 'accessoireSupprimer')]
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
