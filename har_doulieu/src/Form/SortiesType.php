<?php

namespace App\Form;

use App\Entity\Sorties;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortiesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', null, [
                'label' => 'Titre de la sortie',
                'label_attr' => [
                    'class' => 'label'
                ], 'attr'=> [
                    'placeholder' => 'Titre de la sortie',
                    'class' => 'text']

                
            ])
            ->add('date', null,[
                'widget' => 'single_text',
                'label' => 'Titre de la sortie',
                'label_attr' => [
                    'class' => 'label'
                ], 'attr'=> [
                    'placeholder' => 'Date de la sortie',
                    'class' => 'text']

            ])
            
            ->add('lieu', null, [
                'label' => 'Lieu de la sortie',
                'label_attr' => [
                    'class' => 'label'
                ], 'attr'=> [
                    'placeholder' => 'Lieu',
                    'class' => 'text']
            ]) ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sorties::class,
        ]);
    }
}
