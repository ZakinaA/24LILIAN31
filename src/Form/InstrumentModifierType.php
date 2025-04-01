<?php

namespace App\Form;

use App\Entity\Instrument;
use App\Entity\Marque;
use App\Entity\Modele;
use App\Entity\TypeInstrument;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InstrumentModifierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numSerie', TextType::class, [
                'label' => 'Numéro de série',
                'attr' => [
                    'placeholder' => 'Entrez le numéro de série',
                    'class' => 'form-control'
                ]
            ])
            ->add('dateAchat', DateType::class, [
                'label' => 'Date d\'achat',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('prixAchat', NumberType::class, [
                'label' => 'Prix d\'achat',
                'attr' => [
                    'placeholder' => 'Prix en euros',
                    'class' => 'form-control',
                    'step' => '0.01'
                ]
            ])
            ->add('utilisation', ChoiceType::class, [
                'label' => 'Utilisation',
                'choices' => [
                    'Cours' => 'Cours',
                    'Concert' => 'Concert',
                    'Prêt' => 'Prêt',
                    'Cours et prêt' => 'Cours et prêt',
                    'Concert et cours' => 'Concert et cours',
                    'Toutes utilisations' => 'Toutes utilisations'
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('cheminImage', FileType::class, [
                'label' => 'Image de l\'instrument',
                'required' => false,
                'mapped' => false,
                'attr' => [
                    'class' => 'form-control',
                    'accept' => 'image/*'
                ]
            ])
            ->add('couleur', TextType::class, [
                'label' => 'Couleur',
                'attr' => [
                    'placeholder' => 'Couleur de l\'instrument',
                    'class' => 'form-control'
                ]
            ])
            ->add('typeInstrument', EntityType::class, [
                'class' => TypeInstrument::class,
                'choice_label' => 'libelle',
                'label' => 'Type d\'instrument',
                'attr' => [
                    'class' => 'form-control select2-single'
                ]
            ])
            ->add('marque', EntityType::class, [
                'class' => Marque::class,
                'choice_label' => 'libelle',
                'label' => 'Marque',
                'attr' => [
                    'class' => 'form-control select2-single'
                ]
            ])
            ->add('modele', EntityType::class, [
                'class' => Modele::class,
                'choice_label' => 'nom',
                'multiple' => true,
                'expanded' => false,
                'label' => 'Modèle(s)',
                'attr' => [
                    'class' => 'form-control select2-multiple',
                    'data-placeholder' => 'Sélectionnez un ou plusieurs modèles'
                ]
            ])
            ->add('enregistrer', SubmitType::class, [
                'label' => 'Enregistrer les modifications',
                'attr' => [
                    'class' => 'btnEnregistrer'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Instrument::class,
        ]);
    }
}