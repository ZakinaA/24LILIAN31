<?php

namespace App\Form;

use App\Entity\Instrument;
use App\Entity\TypeInstrument;
use App\Entity\Marque;
use App\Entity\Modele;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InstrumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numSerie')
            ->add('dateAchat')
            ->add('prixAchat')
            ->add('utilisation')
            ->add('couleur')

            ->add('typeInstrument', EntityType::class, [
                'class' => TypeInstrument::class,  
                'choice_label' => 'libelle',  
            ])
            ->add('marque', EntityType::class, [
                'class' => Marque::class, 
                'choice_label' => 'libelle',
            ])
            ->add('modele', EntityType::class, [
                'class' => Modele::class,
'choice_label' => 'nom',
'multiple' => true,
'expanded' => true,
            ])

            ->add('cheminImage', FileType::class, [
                'label' => 'Image',
                'mapped' => false, 
                'required' => false,
                'attr' => ['accept' => 'image/*'],
            ])
            ->add('enregistrer', SubmitType::class, ['label' => 'Sauvegarder']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Instrument::class,
        ]);
    }
}

