<?php

namespace App\Form;

use App\Entity\Metier;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use App\Entity\Professionnel;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProfessionnelModifierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('numRue')
            ->add('rue')
            ->add('copos')
            ->add('ville')
            ->add('tel')
            ->add('mail')
            ->add('metiers', EntityType::class, [
                'class' => Metier::class,
                'choice_label' => 'libelle',
                'multiple' => true,
            ])
            ->add('cheminImage', FileType::class, [
                'label' => 'Image du professionnel',
                'mapped' => false, 
                'required' => false,
                'attr' => ['accept' => 'image/*']
            ])
            ->add('enregistrer', SubmitType::class, array('label' => 'Modifier'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Professionnel::class,
        ]);
    }
}
