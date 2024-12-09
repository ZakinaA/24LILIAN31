<?php

namespace App\Controller;

use App\Entity\Professionnel;
use App\Form\ProfessionnelType;
use App\Form\ProfessionnelModifierType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfessionnelController extends AbstractController
{
    // Route pour afficher la liste des professionnels
    #[Route('/professionnel', name: 'app_professionnel')]
    public function index(): Response
    {
        return $this->render('professionnel/index.html.twig', [
            'controller_name' => 'ProfessionnelController',
        ]);
    }

    // Route pour afficher la page d'accueil avec l'année
    #[Route('/accueil', name: 'professionnel_accueil')]
    public function accueil(): Response
    {
        $annee = '2025';
        return $this->render('professionnel/accueil.html.twig', [
            'pAnnee' => $annee,
        ]);
    }

    // Route pour consulter une professionnel spécifique
    #[Route('/professionnel/{id}', name: 'professionnel_consulter', requirements: ['id' => '\d+'])]
public function consulterProfessionnel(ManagerRegistry $doctrine, int $id): Response

    {
        // Récupérer l'professionnel en fonction de son ID
        $professionnel = $doctrine->getRepository(Professionnel::class)->find($id);

        if (!$professionnel) {
            throw $this->createNotFoundException(
                'Aucune professionnel trouvée avec le numéro ' . $id
            );
        }

        return $this->render('professionnel/consulter.html.twig', [
            'professionnel' => $professionnel,
        ]);
    }

    // Route pour lister toutes les professionnels
    #[Route('/professionnel/lister', name: 'professionnel_lister')]
    public function listerProfessionnel(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Professionnel::class);
        $professionnels = $repository->findAll();

        return $this->render('professionnel/lister.html.twig', [
            'iProfessionnels' => $professionnels,
        ]);
    }

    // Route pour ajouter une nouvelle professionnel
    #[Route('/professionnel/ajouter', name: 'professionnel_ajouter')]
    public function ajouterProfessionnel(Request $request, ManagerRegistry $doctrine): Response
    {
        $professionnel = new Professionnel();
        $form = $this->createForm(ProfessionnelType::class, $professionnel);

        // Gérer la soumission du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($professionnel);
            $entityManager->flush();

            // Rediriger après l'ajout
            return $this->redirectToRoute('professionnel_lister');
        }

        return $this->render('professionnel/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // Route pour modifier une professionnel existante
    #[Route('/professionnel/modifier/{id}/', name: 'professionnel_modifier')]
    public function modifierProfessionnel(Request $request, ManagerRegistry $doctrine, int $id): Response
    {
        $professionnel = $doctrine->getRepository(Professionnel::class)->find($id);

        if (!$professionnel) {
            throw $this->createNotFoundException('Aucune professionnel trouvée avec l\'ID ' . $id);
        }

        $form = $this->createForm(ProfessionnelModifierType::class, $professionnel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->flush(); // Mettre à jour l'professionnel
            return $this->redirectToRoute('professionnel_lister');
        }

        return $this->render('professionnel/modifier.html.twig', [
            'form' => $form->createView(),
            'professionnel' => $professionnel,
        ]);
    }

    // Route pour supprimer une professionnel
    #[Route('/professionnel/{id}/delete', name: 'professionnel_supprimer', methods: ['POST'])]
    public function supprimerProfessionnel(Request $request, ManagerRegistry $doctrine, int $id): Response
    {
        $professionnel = $doctrine->getRepository(Professionnel::class)->find($id);

        if (!$professionnel) {
            throw $this->createNotFoundException('Aucune professionnel trouvée avec l\'ID ' . $id);
        }

        // Vérification du token CSRF pour la sécurité
        if ($this->isCsrfTokenValid('delete' . $professionnel->getId(), $request->request->get('_token'))) {
            $entityManager = $doctrine->getManager();
            $entityManager->remove($professionnel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('professionnel_lister');
    }
}
