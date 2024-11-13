<?php

namespace App\Form;

use App\Entity\Cours;
use App\Entity\Jour;
use App\Entity\Professeur;
use App\Entity\TypeCours;
use App\Entity\TypeInstrument;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CoursType extends AbstractType
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
'choice_label' => 'libelle',
            ])
            ->add('typeCours', EntityType::class, [
                'class' => TypeCours::class,
'choice_label' => 'libelle',
            ])
            ->add('professeur', EntityType::class, [
                'class' => Professeur::class,
'choice_label' => 'nom',
            ])
            ->add('typeInstrument', EntityType::class, [
                'class' => TypeInstrument::class,
'choice_label' => 'libelle',
            ])
            ->add('enregistrer', SubmitType::Class, array('label' => 'nouveau'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cours::class,
        ]);
    }
}
