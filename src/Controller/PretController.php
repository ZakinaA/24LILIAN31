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
    #[Route('/pret', name: 'app_pret')]
    public function index(): Response
    {
        return $this->render('pret/index.html.twig', [
            'controller_name' => 'PretController',
        ]);
    }

    #[Route('/eleve/pret/lister', name: 'pret_lister_eleve')]
    #[Route('/admin/pret/lister', name: 'pret_lister_admin')]
    public function listerPret(ManagerRegistry $doctrine): Response
    {
        if ($this->isGranted('ROLE_ADMIN') || $this->isGranted('ROLE_ELEVE')) {
           
        } else {
            throw $this->createAccessDeniedException('Accès non autorisé');
        }

        $repository = $doctrine->getRepository(Pret::class);
        $prets = $repository->findAll();

        return $this->render('pret/lister.html.twig', [
            'pPrets' => $prets,
        ]);
    }

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

    #[Route('/pret/new', name: 'pret_ajouter')]
    public function ajouterPret(Request $request, ManagerRegistry $doctrine): Response
    {
        $pret = new Pret();
        $form = $this->createForm(PretType::class, $pret);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($pret);
            $entityManager->flush();

            return $this->redirectToRoute('pret_lister');
        }

        return $this->render('pret/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

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
            $entityManager->flush(); 
            return $this->redirectToRoute('pret_lister');
        }

        return $this->render('pret/modifier.html.twig', [
            'form' => $form->createView(),
            'pret' => $pret,
        ]);
    }

    #[Route('/pret/{id}/delete', name: 'pret_supprimer', methods: ['POST'])]
    public function supprimerPret(Request $request, ManagerRegistry $doctrine, int $id): Response
    {
        $pret = $doctrine->getRepository(Pret::class)->find($id);

        if (!$pret) {
            throw $this->createNotFoundException('Aucun prêt trouvé avec l\'ID ' . $id);
        }

        if ($this->isCsrfTokenValid('delete' . $pret->getId(), $request->request->get('_token'))) {
            $entityManager = $doctrine->getManager();
            $entityManager->remove($pret);
            $entityManager->flush();
        }

        return $this->redirectToRoute('pret_lister');
    }
}
