<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\OptionGuide;
use App\Entity\OptionTransport;
use App\Entity\Programme;
use App\Entity\Statut;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ProgrammeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Titre')
            ->add('Description')
            ->add('prix')
            ->add('date')
            ->add('adresse')
            ->add('category',EntityType::class,[
                'class'=> Category::class,
                'choice_label'=> 'titre'])
            ->add('statut',EntityType::class,[
        'class'=> Statut::class,
        'choice_label'=> 'nom'])
            ->add('images',FileType::class,['label'=> false, 'multiple' => true, 'mapped'=>false, 'required'=>false])

            ->add('guide',EntityType::class,[
                'class'=> OptionGuide::class,
                'choice_label'=> 'nom'
            ])
            ->add('transport',EntityType::class,[
                'class'=> OptionTransport::class,
                'choice_label'=> 'matricule'])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Programme::class,
        ]);
    }
}