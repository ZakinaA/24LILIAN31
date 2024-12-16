<?php

namespace App\Controller;

use App\Entity\Intervention;
use App\Form\InterventionType;
use App\Form\InterventionModifierType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InterventionController extends AbstractController
{
    
    #[Route('gestionnaire/intervention/{id}', name: 'intervention_consulter', requirements: ['id' => '\d+'])]
public function consulterIntervention(ManagerRegistry $doctrine, int $id): Response

    {
        $intervention = $doctrine->getRepository(Intervention::class)->find($id);

        if (!$intervention) {
            throw $this->createNotFoundException(
                'Aucune intervention trouvée avec le numéro ' . $id
            );
        }

        return $this->render('intervention/consulter.html.twig', [
            'intervention' => $intervention,
        ]);
    }

    #[Route('gestionnaire/intervention/lister', name: 'intervention_lister')]
    public function listerIntervention(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Intervention::class);
        $interventions = $repository->findAll();

        return $this->render('intervention/lister.html.twig', [
            'iInterventions' => $interventions,
        ]);
    }

    #[Route('gestionnaire/intervention/new', name: 'intervention_ajouter')]
    public function ajouterIntervention(Request $request, ManagerRegistry $doctrine): Response
    {
        $intervention = new Intervention();
        $form = $this->createForm(InterventionType::class, $intervention);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($intervention);
            $entityManager->flush();

            return $this->redirectToRoute('intervention_lister');
        }

        return $this->render('intervention/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('gestionnaire/intervention/{id}/edit', name: 'intervention_modifier')]
    public function modifierIntervention(Request $request, ManagerRegistry $doctrine, int $id): Response
    {
        $intervention = $doctrine->getRepository(Intervention::class)->find($id);

        if (!$intervention) {
            throw $this->createNotFoundException('Aucune intervention trouvée avec l\'ID ' . $id);
        }

        $form = $this->createForm(InterventionModifierType::class, $intervention);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('intervention_lister');
        }

        return $this->render('intervention/modifier.html.twig', [
            'form' => $form->createView(),
            'intervention' => $intervention,
        ]);
    }

    #[Route('gestionnaire/intervention/{id}/delete', name: 'intervention_supprimer', methods: ['POST'])]
    public function supprimerIntervention(Request $request, ManagerRegistry $doctrine, int $id): Response
    {
        $intervention = $doctrine->getRepository(Intervention::class)->find($id);

        if (!$intervention) {
            throw $this->createNotFoundException('Aucune intervention trouvée avec l\'ID ' . $id);
        }

        if ($this->isCsrfTokenValid('delete' . $intervention->getId(), $request->request->get('_token'))) {
            $entityManager = $doctrine->getManager();
            $entityManager->remove($intervention);
            $entityManager->flush();
        }

        return $this->redirectToRoute('intervention_lister');
    }
}
