<?php

namespace App\Controller;

use App\Entity\Pret;
use App\Form\PretType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PretController extends AbstractController
{
    // Route pour afficher la liste des prêts
    #[Route('/pret', name: 'app_pret')]
    public function index(): Response
    {
        return $this->render('pret/index.html.twig', [
            'controller_name' => 'PretController',
        ]);
    }

    // Route pour lister tous les prêts
    #[Route('/pret/lister', name: 'pret_lister')]
    public function listerPret(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Pret::class);
        $prets = $repository->findAll();

        return $this->render('pret/lister.html.twig', [
            'pPrets' => $prets,
        ]);
    }

    // Route pour consulter un prêt spécifique
    #[Route('/pret/{id}', name: 'pret_consulter', requirements: ['id' => '\d+'])]
    public function consulterPret(ManagerRegistry $doctrine, int $id): Response
    {
        $pret = $doctrine->getRepository(Pret::class)->find($id);

        if (!$pret) {
            throw $this->createNotFoundException(
                'Aucun prêt trouvé avec le numéro ' . $id
            );
        }

        return $this->render('pret/consulter.html.twig', [
            'pret' => $pret,
        ]);
    }

    // Route pour ajouter un nouveau prêt
    #[Route('/pret/new', name: 'pret_ajouter')]
    public function ajouterPret(Request $request, ManagerRegistry $doctrine): Response
    {
        $pret = new Pret();
        $form = $this->createForm(PretType::class, $pret);

        // Gérer la soumission du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($pret);
            $entityManager->flush();

            // Rediriger après l'ajout
            return $this->redirectToRoute('pret_lister');
        }

        return $this->render('pret/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // Route pour modifier un prêt existant
    #[Route('/pret/{id}/edit', name: 'pret_modifier')]
    public function modifierPret(Request $request, ManagerRegistry $doctrine, int $id): Response
    {
        $pret = $doctrine->getRepository(Pret::class)->find($id);

        if (!$pret) {
            throw $this->createNotFoundException('Aucun prêt trouvé avec l\'ID ' . $id);
        }

        $form = $this->createForm(PretType::class, $pret);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->flush(); // Mettre à jour le prêt
            return $this->redirectToRoute('pret_lister');
        }

        return $this->render('pret/modifier.html.twig', [
            'form' => $form->createView(),
            'pret' => $pret,
        ]);
    }

    // Route pour supprimer un prêt
    #[Route('/pret/{id}/delete', name: 'pret_supprimer', methods: ['POST'])]
    public function supprimerPret(Request $request, ManagerRegistry $doctrine, int $id): Response
    {
        $pret = $doctrine->getRepository(Pret::class)->find($id);

        if (!$pret) {
            throw $this->createNotFoundException('Aucun prêt trouvé avec l\'ID ' . $id);
        }

        // Vérification du token CSRF pour la sécurité
        if ($this->isCsrfTokenValid('delete' . $pret->getId(), $request->request->get('_token'))) {
            $entityManager = $doctrine->getManager();
            $entityManager->remove($pret);
            $entityManager->flush();
        }

        return $this->redirectToRoute('pret_lister');
    }
}
