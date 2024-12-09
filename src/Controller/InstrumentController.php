<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Pret;
use Symfony\Component\String\Slugger\AsciiSlugger;
use App\Entity\Intervention;
use App\Entity\Instrument;
use App\Entity\Maison;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Form\InstrumentType;
use App\Form\InstrumentModifierType;

class InstrumentController extends AbstractController
{
    #[Route('/instrument', name: 'app_instrument')]
    public function index(): Response
    {
        return $this->render('instrument/index.html.twig', [
            'controller_name' => 'InstrumentController',
        ]);
    }

    public function accueil(): Response
    {
        $annee = '2025';
        return $this->render('instrument/accueil.html.twig', [
            'pAnnee' => $annee,
        ]);
    }

    public function consulterInstrument(ManagerRegistry $doctrine, int $id)
{
    $instrument = $doctrine->getRepository(Instrument::class)->find($id);

    if (!$instrument) {
        throw $this->createNotFoundException('Aucun instrument trouvé avec le numéro ' . $id);
    }

    $interventions = $doctrine->getRepository(Intervention::class)->findBy(['instrument' => $instrument]);

    $prets = $doctrine->getRepository(Pret::class)->findBy(['instrument' => $instrument]);

    return $this->render('instrument/consulter.html.twig', [
        'instrument' => $instrument,
        'interventions' => $interventions,
        'prets' => $prets,
    ]);
}



    public function listerInstrument(ManagerRegistry $doctrine){

        $repository = $doctrine->getRepository(Instrument::class);

        $instruments= $repository->findAll();
        return $this->render('instrument/lister.html.twig', [
        'pInstruments' => $instruments,]);	
    }

    public function modifierInstrument(ManagerRegistry $doctrine, $id, Request $request)
    {
        $instrument = $doctrine->getRepository(Instrument::class)->find($id);
    
        if (!$instrument) {
            throw $this->createNotFoundException('Aucun instrument trouvé avec le numéro ' . $id);
        }
    
        $form = $this->createForm(InstrumentModifierType::class, $instrument);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $doctrine->getManager();
            $entityManager->persist($instrument);
            $entityManager->flush();
    
            return $this->render('instrument/consulter.html.twig', ['instrument' => $instrument]);
        }
    
        return $this->render('instrument/modifier.html.twig', ['form' => $form->createView()]);
    }
    
    public function ajouterInstrument(ManagerRegistry $doctrine, Request $request)
    {
        $instrument = new Instrument();
        $form = $this->createForm(InstrumentType::class, $instrument);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
    
            $imageFile = $form->get('cheminImage')->getData();
    
            if ($imageFile) {
    
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
    
                
                $slugger = new AsciiSlugger();
                $safeFilename = $slugger->slug($originalFilename)->toString();
                
                
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension(); 
    
                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'), 
                        $newFilename
                    );
                } catch (FileException $e) {
                    throw new \Exception('Erreur lors du téléchargement de l\'image');
                }
    
                $instrument->setCheminImage($newFilename);
            }
    
            $entityManager = $doctrine->getManager();
            $entityManager->persist($instrument);
            $entityManager->flush();
    
            return $this->render('instrument/consulter.html.twig', ['instrument' => $instrument]);
        }
    
        return $this->render('instrument/ajouter.html.twig', ['form' => $form->createView()]);
    }


    public function supprimerInstrument(ManagerRegistry $doctrine, int $id): Response
{
    $instrument = $doctrine->getRepository(Instrument::class)->find($id);

    if (!$instrument) {
        throw $this->createNotFoundException('Aucun instrument trouvé avec l ID '.$id);
    }

    $entityManager = $doctrine->getManager();
    $entityManager->remove($instrument); 
    $entityManager->flush();

    return $this->redirectToRoute('instrumentLister');
}
}
