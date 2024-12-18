<?php


namespace App\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Professeur;
use App\Form\ProfesseurType;
use App\Form\ProfesseurModifierType;


class ProfesseurController extends AbstractController
{
   
    #[Route('/gestionnaire/professeur/consulter/{id}', name: 'professeurConsulter')]
    public function consulterProfesseur(ManagerRegistry $doctrine, int $id)
    {
        $professeur = $doctrine->getRepository(Professeur::class)->find($id);
   
        if (!$professeur) {
            throw $this->createNotFoundException('Aucun professeur trouvé avec le numéro ' . $id);
        }
   
        $cours = $professeur->getCours();
   
        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
        $heures = range(14, 22); 
        $planning = [];
   
        foreach ($jours as $jour) {
            foreach ($heures as $heure) {
                $planning[$jour][$heure] = null;
            }
        }
   
        foreach ($cours as $cour) {
            $jour = $cour->getJour()->getLibelle(); 
            $heureDebut = (int)$cour->getHeureDebut()->format('H');
            $heureFin = (int)$cour->getHeureFin()->format('H');
   
            for ($heure = $heureDebut; $heure < $heureFin; $heure++) {
                $planning[$jour][$heure] = $cour->getLibelle();
            }
        }
   
        return $this->render('professeur/consulter.html.twig', [
            'professeur' => $professeur,
            'planning' => $planning,
            'heures' => $heures,
            'jours' => $jours,
            'cours' => $cours,
        ]);
    }

    
    #[Route('/gestionnaire/professeur/lister', name: 'professeurLister')]
    public function listerProfesseur(ManagerRegistry $doctrine)
    {
        $repository = $doctrine->getRepository(Professeur::class);
        $professeurs = $repository->findAll();
        return $this->render('professeur/lister.html.twig', [
            'pProfesseurs' => $professeurs,
        ]);
    }

    
    #[Route('/gestionnaire/professeur/modifier/{id}', name: 'professeurModifier')]
    public function modifierProfesseur(ManagerRegistry $doctrine, $id, Request $request, SluggerInterface $slugger)
{
    $professeur = $doctrine->getRepository(Professeur::class)->find($id);
   
    if (!$professeur) {
        throw $this->createNotFoundException('Aucun professeur trouvé avec le numéro '.$id);
    }
   
    $form = $this->createForm(ProfesseurModifierType::class, $professeur);
    $form->handleRequest($request);
   
    if ($form->isSubmitted() && $form->isValid()) {
        $professeur = $form->getData();
        
        $imageFile = $form->get('cheminImage')->getData();
        if ($imageFile) {
            $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

            try {
                $imageFile->move(
                    $this->getParameter('professeur_directory'),
                    $newFilename
                );

                $professeur->setCheminImage('professeur/' . $newFilename);
            } catch (FileException $e) {

                $this->addFlash('error', 'Une erreur est survenue lors du téléchargement de l\'image.');
            }
        }

        $entityManager = $doctrine->getManager();
        $entityManager->persist($professeur);
        $entityManager->flush();

        return $this->render('professeur/consulter.html.twig', ['professeur' => $professeur]);
    }

    return $this->render('professeur/ajouter.html.twig', ['form' => $form->createView()]);
}


    #[Route('/gestionnaire/professeur/ajouter', name: 'professeurAjouter')]
    public function ajouterProfesseur(Request $request): Response
    {
        $professeur = new Professeur();
        $form = $this->createForm(ProfesseurType::class, $professeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer le fichier de l'image
            $imageFile = $form->get('cheminImage')->getData();

            if ($imageFile) {
                try {
                    // Créer un nom unique pour l'image
                    $newFilename = uniqid() . '.' . $imageFile->getClientOriginalExtension();

                    // Déplacer l'image dans le répertoire 'public/professeur'
                    $imageFile->move(
                        $this->getParameter('professeur_directory'), // Répertoire public/professeur
                        $newFilename
                    );

                    // Définir le chemin d'image dans l'entité Professeur
                    $professeur->setCheminImage('professeur/' . $newFilename);
                } catch (FileException $e) {
                    // Si une erreur survient lors du téléchargement, afficher un message
                    $this->addFlash('error', 'Une erreur est survenue lors du téléchargement de l\'image.');
                    return $this->redirectToRoute('professeur_list'); // ou votre route après l'erreur
                }
            }

            // Persister l'entité professeur dans la base de données
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($professeur);
            $entityManager->flush();

            // Message de succès
            $this->addFlash('success', 'Le professeur a été ajouté avec succès.');

            // Rediriger vers la liste des professeurs après l'ajout
            return $this->redirectToRoute('professeur_list');
        }

        // Rendre la vue du formulaire pour ajouter un professeur
        return $this->render('professeur/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }



    
    #[Route('gestionnaire/professeur/supprimer/{id}', name: 'professeurSupprimer')]
    public function supprimerProfesseur(ManagerRegistry $doctrine, $id)
    {
        $em = $doctrine->getManager(); 
   
        $professeur = $em->getRepository(Professeur::class)->find($id);
   
        if (!$professeur) {
            throw $this->createNotFoundException('Le professeur avec l\'ID ' . $id . ' n\'existe pas.');
        }
   
        $coursRepository = $em->getRepository(Cours::class);
        $cours = $coursRepository->findBy(['professeur' => $professeur]);
   
        foreach ($cours as $cour) {
            $cour->setProfesseur(null); 
            $em->persist($cour);
        }
   
        $em->remove($professeur);
        $em->flush();
   
        return $this->redirectToRoute('professeurLister');
    }
}


 

