<?php

namespace App\Form;

use App\Entity\User;
use phpDocumentor\Reflection\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username')
            ->add('tel')
            ->add('firstName')
            ->add('lastName')
            ->add('picture', FileType::class, [

                'required' => false,
                'data_class' => null
            ])
            // ...

        ;
    }

}
