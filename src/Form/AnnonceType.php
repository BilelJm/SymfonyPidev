<?php

namespace App\Form;

use App\Entity\Annonce;
use App\Entity\Promotion;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('prix')
            ->add('disponible')
            ->add('description')
            ->add('type')
            ->add('date')
            ->add('images',FileType::class,[
              'multiple' => true,
                  'mapped'=>false,
                'required'=>false
    ])
            ->add('promotion',EntityType::class,[
                'class'=> Promotion::class,
                'choice_label'=> 'taux'
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
