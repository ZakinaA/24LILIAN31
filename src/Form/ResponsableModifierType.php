<?php

namespace App\Form;

use App\Entity\Responsable;
use App\Entity\User;
use App\Entity\QuotientFamilial;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResponsableModifierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('numRue')
            ->add('rue')
            ->add('copos')
            ->add('ville')
            ->add('tel')
            ->add('cheminImage', FileType::class, [
                'label' => 'Choisir une image',
                'required' => false,
                'mapped' => false,
            ])
            ->add('compte', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email',
            ])
            ->add('quotientFamilial', EntityType::class, [
                'class' => QuotientFamilial::class,
                'choice_label' => 'quotienMini',
            ])
            ->add('enregistrer', SubmitType::class, array('label' => 'Créer'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Responsable::class,
        ]);
    }
}
