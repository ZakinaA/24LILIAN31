<?php

namespace App\Form;

use App\Entity\Instrument;
use App\Entity\Marque;
use App\Entity\Modele;
use App\Entity\TypeInstrument;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
            ->add('cheminImage')
            ->add('couleur')
            ->add('typeInstrument', EntityType::class, [
                'class' => TypeInstrument::class,
'choice_label' => 'id',
            ])
            ->add('marque', EntityType::class, [
                'class' => Marque::class,
'choice_label' => 'id',
            ])
            ->add('modele', EntityType::class, [
                'class' => Modele::class,
'choice_label' => 'id',
'multiple' => true,
            ])
            ->add('enregistrer', SubmitType::class, array('label' => 'nouveau'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Instrument::class,
        ]);
    }
}
