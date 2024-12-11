<?php

namespace App\Form;

use App\Entity\Cours;
use App\Entity\Eleve;
use App\Entity\Inscription;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InscriptionModifierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateInscription', null, [
                'widget' => 'single_text',
            ])
            ->add('cours', EntityType::class, [
                'class' => Cours::class,
                'choice_label' => 'libelle',
            ])
            ->add('eleve', EntityType::class, [
                'class' => Eleve::class,
                'choice_label' => 'nom','prenom',
            ])
            ->add('enregistrer', SubmitType::class, array('label' => 'Enregistrer modification'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Inscription::class,
        ]);
    }
}
