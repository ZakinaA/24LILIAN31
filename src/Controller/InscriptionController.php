<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CoursRepository;
use App\Repository\InscriptionRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Inscription;
use App\Form\InscriptionType;
use App\Form\InscriptionModifierType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscription')]
    public function index(): Response
    {
        return $this->render('inscription/index.html.twig', [
            'controller_name' => 'InscriptionController',
        ]);
    }

    #[Route('/inscription/ajouter', name: 'inscription_ajouter')]
    public function ajouter(ManagerRegistry $doctrine, Request $request): Response
    {
        $inscription = new Inscription();
        $form = $this->createForm(InscriptionType::class, $inscription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($inscription);
            $entityManager->flush();

            return $this->redirectToRoute('inscription_lister', ['id' => $inscription->getId()]);
        }

        return $this->render('inscription/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function modifierInscription($id, Request $request, ManagerRegistry $doctrine, InscriptionRepository $inscriptionRepo, CoursRepository $coursRepo)
{
    // Fetch the inscription to be modified
    $inscription = $inscriptionRepo->find($id);

    if (!$inscription) {
        throw $this->createNotFoundException('Inscription not found');
    }

    // Fetch all available courses
    $coursList = $coursRepo->findAll();

    // Create the form for updating the inscription
    $form = $this->createFormBuilder($inscription)
        ->add('dateInscription', DateType::class, [
            'widget' => 'single_text',
            'label' => 'Date d\'inscription',
        ])
        ->add('cours', ChoiceType::class, [
            'choices' => $coursList,
            'choice_label' => function($cours) {
                return $cours->getLibelle();  // Assuming 'libelle' is the name of the course
            },
            'choice_value' => function($cours) {
                return $cours ? $cours->getId() : null;  // Assuming 'id' is the identifier
            },
            'label' => 'Choisir un cours'
        ])
        ->add('submit', SubmitType::class, ['label' => 'Mettre à jour'])
        ->getForm();

    // Handle the form submission
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Persist the changes to the database
        $entityManager = $doctrine->getManager();
        $entityManager->flush();

        // Redirect to the inscription list or success page
        return $this->redirectToRoute('inscription_lister');
    }

    // Render the form
    return $this->render('inscription/modifier.html.twig', [
        'form' => $form->createView(),
        'inscription' => $inscription,
        'cours_list' => $coursList
    ]);
}


    #[Route('/inscription/lister', name: 'inscription_lister')]
    public function listerInscription(ManagerRegistry $doctrine): Response
    {
        $inscriptions = $doctrine->getRepository(Inscription::class)->findAll();

        return $this->render('inscription/lister.html.twig', [
            'inscriptions' => $inscriptions,
        ]);
    }

    #[Route('/inscription/supprimer/{id}', name: 'inscription_supprimer', methods: ['POST'])]
    public function supprimerInscription(ManagerRegistry $doctrine, int $id, Request $request): Response
    {
        $inscription = $doctrine->getRepository(Inscription::class)->find($id);

        if (!$inscription) {
            throw $this->createNotFoundException('Aucune inscription trouvée avec l\'ID '.$id);
        }

        if ($this->isCsrfTokenValid('delete'.$id, $request->request->get('_token'))) {
            $entityManager = $doctrine->getManager();
            $entityManager->remove($inscription);
            $entityManager->flush();
        }

        return $this->redirectToRoute('inscription_lister');
    }
}

