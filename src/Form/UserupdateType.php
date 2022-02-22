<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserupdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('username')
            ->add('firstName')
            ->add('lastName')
            ->add('tel')
            ->add('email')

            ->add(
                'roles', ChoiceType::class, [
                    'choices' => ['Administrateur'=>'ROLE_ADMIN','Utilisateur'=>'ROLE_USER'],
                    'expanded' => true,
                    'multiple' => true,

                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
