<?php

namespace App\Form;

use App\Entity\Eleves;
use App\Entity\Instrument;
use App\Entity\Pupitres;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InstrumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder



            ->add('numero_serie', null, [
                
                'label' => 'Numéro de série',
                'label_attr' => [
                    'class' => 'label'
                ],
                'attr' => [
                    'placeholder' => 'Numéro de série',
                    'class' => 'text'
                    
                ]
                
            ])

            
            

            ->add('marque', null, [
                'label' => 'Marque',
                'label_attr' => [
                    'class' => 'label'
                ],
                'attr' => [
                    'placeholder' => 'Marque',
                    'class' => 'text'
                ]
            ])
            ->add('pupitre', EntityType::class, [
                'label' => 'Pupitre',
                'label_attr' => [
                    'class' => 'label'
                ],
                'class' => Pupitres::class,
                'choice_label' => 'nom',
                'attr' => [
                    'class' => 'select'
                ]
            ])
            ->add('locataire_musicien', EntityType::class, [
                'label' => 'Locataire',
                'label_attr' => [
                    'class' => 'label'
                ],
                'class' => User::class,
                'choice_label' => 'pseudo',
                'attr' => [
                    'class' => 'select'
                ]
            ])
            ->add('locataire_eleves', EntityType::class, [
                'label' => 'Locataire',
                'label_attr' => [
                    'class' => 'label'
                ],
                'class' => Eleves::class,
                'choice_label' => 'pseudo',
                'attr' => [
                    'class' => 'select'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Instrument::class,
        ]);
    }
}
