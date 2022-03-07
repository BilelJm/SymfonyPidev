<?php

namespace App\Form;

use App\Entity\Prosearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

           $builder
               ->add('prix',null,['label' => 'Recherche par Prix ',
                   'attr' => ['requied' => false,
                       'placeholder' => 'Entrer le prix d\'un article'] ] ) ;
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Prosearch::class,
        ]);
    }
}
