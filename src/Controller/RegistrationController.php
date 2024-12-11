<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Responsable;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
{
    $user = new User();
    $form = $this->createForm(RegistrationFormType::class, $user);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        /** @var string $plainPassword */
        $plainPassword = $form->get('plainPassword')->getData();

        $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));

        // Récupérer le Responsable depuis le formulaire
        $responsable = $user->getResponsable();
        
        // Gérer le fichier téléchargé (image)
        /** @var UploadedFile $cheminImage */
        $cheminImage = $form->get('responsable')->get('cheminImage')->getData();

        if ($cheminImage) {
            // Gérer le chemin de l'image (par exemple, dans le dossier 'uploads')
            $destination = $this->getParameter('responsable_directory');  // Paramètre dans services.yaml ou config/services.yaml
            $newFilename = uniqid().'.'.$cheminImage->guessExtension();

            try {
                // Déplace le fichier téléchargé vers le dossier cible
                $cheminImage->move(
                    $destination,
                    $newFilename
                );
            } catch (FileException $e) {
                // Si une erreur survient, vous pouvez gérer cela
                // Par exemple, afficher un message d'erreur ou loguer l'exception
            }

            $responsable->setCheminImage($newFilename);
        }

        $responsable->setCompte($user);

        $entityManager->persist($user);
        $entityManager->persist($responsable);
        $entityManager->flush();

        return $this->redirectToRoute('app_login');
    }

    return $this->render('registration/register.html.twig', [
        'registrationForm' => $form->createView(),
    ]);
}
}