<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchForm extends AbstractType
{
public function  configureOptions(OptionsResolver $resolver)
{


}

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('min', IntegerType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Prix minimal'
                ]
            ])
            ->add('max', IntegerType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Prix maximal'
                ]
            ])
            ->add('promo', CheckboxType::class, [
                'label' => 'En promotion',
                'required' => false,
            ])
        ;
    }


}