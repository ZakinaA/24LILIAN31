<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CoursRepository;
use App\Repository\TarifRepository;
use App\Repository\InscriptionRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Inscription;
use App\Form\InscriptionType;
use App\Form\InscriptionModifierType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\EntityManagerInterface;

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

            return $this->redirectToRoute('inscription_montant', ['id' => $inscription->getId()]);
        }

        return $this->render('inscription/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function modifierInscription(Request $request, $id, InscriptionRepository $inscriptionRepository, EntityManagerInterface $entityManager)
    {
        // Récupérer l'inscription à modifier
        $inscription = $inscriptionRepository->find($id);

        if (!$inscription) {
            throw $this->createNotFoundException('Inscription non trouvée');
        }

        // Création du formulaire pour modifier l'inscription
        $form = $this->createForm(InscriptionType::class, $inscription);
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide, on met à jour
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();  // Enregistre les modifications en base de données

            $this->addFlash('success', 'Inscription mise à jour avec succès!');
            return $this->redirectToRoute('inscription_consulter', ['id' => $id]);  // Redirige vers la page consulter après modification
        }

        // Afficher le formulaire pour modifier les données
        return $this->render('inscription/modifier.html.twig', [
            'form' => $form->createView(),
            'inscription' => $inscription,
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

    #[Route('/inscription/{id}/montant', name: 'inscription_montant')]
public function inscriptionMontant(
    Request $request,
    Inscription $inscription,
    TarifRepository $tarifRepository,
    CoursRepository $coursRepository
): Response {
    $eleve = $inscription->getEleve();
    $responsable = $eleve->getResponsable();

    if (!$responsable) {
        throw $this->createNotFoundException('Responsable non trouvé pour cet élève.');
    }

    $quotientFamilial = $responsable->getQuotientFamilial();

    if (!$quotientFamilial) {
        throw $this->createNotFoundException('Quotient familial non trouvé pour ce responsable.');
    }

    $totalMontant = 0;
    $montants = [];

    foreach ($responsable->getEleves() as $eleve) {
        $quotientFamilial = $eleve->getResponsable()->getQuotientFamilial();
        if (!$quotientFamilial) {
            throw $this->createNotFoundException('Quotient familial non trouvé pour cet élève.');
        }

        $tarifs = $quotientFamilial->getTarifs();
        if (count($tarifs) === 0) {
            throw $this->createNotFoundException('Aucun tarif trouvé pour ce quotient familial.');
        }

        $tarif = $tarifs->first(); 

        if (!$tarif) {
            throw $this->createNotFoundException('Tarif non trouvé dans la collection.');
        }

        $montants[] = [
            'eleve' => $eleve->getNom(),
            'montant' => $tarif->getMontant()
        ];
        $totalMontant += $tarif->getMontant();
    }

    return $this->render('inscription/montant.html.twig', [
        'inscription' => $inscription,
        'montants' => $montants, 
        'totalMontant' => $totalMontant, 
    ]);
}

    
    #[Route('/inscription/consulter/{id}', name: 'inscription_consulter')]
    
   public function consulterInscription($id, InscriptionRepository $inscriptionRepository)
   {
       // Récupérer les données de l'inscription
       $inscription = $inscriptionRepository->find($id);
   
       if (!$inscription) {
           throw $this->createNotFoundException('Inscription non trouvée');
       }
   
       // Rendu du template de consultation
       return $this->render('inscription/consulter.html.twig', [
           'inscription' => $inscription
       ]);
   }
}