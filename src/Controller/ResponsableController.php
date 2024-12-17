<?php

namespace App\Controller;

use App\Entity\Responsable;
use App\Form\ResponsableType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResponsableController extends AbstractController
{
    #[Route('/gestionnaire/responsable/lister', name: 'gestionnaireListerResponsable')]
    public function listerResponsable(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Responsable::class);
        $responsables = $repository->findAll();

        return $this->render('responsable/lister.html.twig', [
            'responsables' => $responsables,
        ]);
    }

    #[Route('/gestionnaire/responsable/ajouter', name: 'gestionnaireAjouterResponsable')]
    public function ajouterResponsable(ManagerRegistry $doctrine, Request $request): Response
    {
        $responsable = new Responsable();
        $form = $this->createForm(ResponsableType::class, $responsable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $form['cheminImage']->getData();

            if ($uploadedFile) {
                $destination = $this->getParameter('kernel.project_dir') . '/public/responsable';
                $newFilename = uniqid() . '.' . $uploadedFile->guessExtension();
                $uploadedFile->move($destination, $newFilename);

                $responsable->setCheminImage($newFilename);
            }

            $entityManager = $doctrine->getManager();
            $entityManager->persist($responsable);
            $entityManager->flush();

            return $this->redirectToRoute('gestionnaireListerResponsable');
        }

        return $this->render('responsable/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/gestionnaire/responsable/consulter/{id}', name: 'gestionnaireConsulterResponsable')]
    public function consulterResponsable(ManagerRegistry $doctrine, int $id): Response
    {
        $responsable = $doctrine->getRepository(Responsable::class)->find($id);
        
        if (!$responsable) {
            throw $this->createNotFoundException('Aucun responsable trouvé avec le numéro ' . $id);
        }

        return $this->render('responsable/consulter.html.twig', [
            'responsable' => $responsable,
        ]);
    }

    #[Route('/gestionnaire/responsable/modifier/{id}', name: 'gestionnaireModifierResponsable')]
    public function modifierResponsable(ManagerRegistry $doctrine, int $id, Request $request): Response
    {
        $responsable = $doctrine->getRepository(Responsable::class)->find($id);

        if (!$responsable) {
            throw $this->createNotFoundException('Aucun responsable trouvé avec le numéro ' . $id);
        }

        $form = $this->createForm(ResponsableType::class, $responsable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $form['cheminImage']->getData();

            if ($uploadedFile) {
                $destination = $this->getParameter('kernel.project_dir') . '/public/responsable';
                $newFilename = uniqid() . '.' . $uploadedFile->guessExtension();
                $uploadedFile->move($destination, $newFilename);

                $responsable->setCheminImage($newFilename);
            }

            $entityManager = $doctrine->getManager();
            $entityManager->persist($responsable);
            $entityManager->flush();

            return $this->redirectToRoute('gestionnaireListerResponsable');
        }

        return $this->render('responsable/modifier.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/gestionnaire/responsable/supprimer/{id}', name: 'gestionnaireSupprimerResponsable')]
    public function supprimerResponsable(ManagerRegistry $doctrine, int $id): Response
    {
        $responsable = $doctrine->getRepository(Responsable::class)->find($id);

        if (!$responsable) {
            throw $this->createNotFoundException('Aucun responsable trouvé avec l ID ' . $id);
        }

        $entityManager = $doctrine->getManager();
        $entityManager->remove($responsable);
        $entityManager->flush();

        return $this->redirectToRoute('gestionnaireListerResponsable');
    }
}
