<?php

namespace App\Form;

use App\Entity\ClasseInstrument;
use App\Entity\Professeur;
use App\Entity\TypeInstrument;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypeInstrumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle')
            ->add('professeurs', EntityType::class, [
                'class' => Professeur::class,
'choice_label' => 'id',
'multiple' => true,
            ])
            ->add('classeInstrument', EntityType::class, [
                'class' => ClasseInstrument::class,
'choice_label' => 'id',
            ])
            ->add('enregistrer', SubmitType::class, array('label' => 'nouveau'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TypeInstrument::class,
        ]);
    }
}
