<?php

namespace App\Form;

use App\Entity\Cours;
use App\Entity\Jour;
use App\Entity\Professeur;
use App\Entity\TypeCours;
use App\Entity\TypeInstrument;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CoursModifierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle')
            ->add('ageMini')
            ->add('heureDebut')
            ->add('heureFin')
            ->add('jour', EntityType::class, [
                'class' => Jour::class,
'choice_label' => 'id',
            ])
            ->add('typeCours', EntityType::class, [
                'class' => TypeCours::class,
'choice_label' => 'id',
            ])
            ->add('professeur', EntityType::class, [
                'class' => Professeur::class,
'choice_label' => 'id',
            ])
            ->add('typeInstrument', EntityType::class, [
                'class' => TypeInstrument::class,
'choice_label' => 'id',
            ])
            ->add('enregistrer', SubmitType::Class, array('label' => 'Modifier'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cours::class,
        ]);
    }
}
