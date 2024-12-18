<?php

namespace App\Form;

use App\Entity\Accessoire;
use App\Entity\Instrument;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AccessoireModifierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle', TextType::class)
            ->add('cheminImage', FileType::class, [
                'label' => 'Image (JPG, PNG)',
                'required' => false,
                'attr' => ['accept' => 'image/*'],
            ])
            ->add('enregistrer', SubmitType::class, ['label' => 'Modifier']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Accessoire::class,
        ]);
    }
}

