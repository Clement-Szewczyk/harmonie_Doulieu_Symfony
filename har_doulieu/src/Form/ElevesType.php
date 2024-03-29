<?php

namespace App\Form;

use App\Entity\Eleves;
use App\Entity\Pupitres;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ElevesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', null, [
                'label' => 'Nom',
                'label_attr' => [
                    'class' => 'label'
                ],
                'attr' => [
                    'placeholder' => 'Nom',
                    'class' => 'text'
                ]
            ])
            ->add('prenom', null, [
                'label' => 'Prénom',
                'label_attr' => [
                    'class' => 'label'
                ],
                'attr' => [
                    'placeholder' => 'Prénom',
                    'class' => 'text'
                ]
            ])
            ->add('email', null, [
                'label' => 'Email',
                'label_attr' => [
                    'class' => 'label'
                ],
                'attr' => [
                    'placeholder' => 'Email',
                    'class' => 'text'
                ]
            ])
            ->add('date_naissance', null, [
                'widget' => 'single_text',
                'label' => 'Date de naissance',
                'label_attr' => [
                    'class' => 'label'
                ],
                'attr' => [
                    'placeholder' => 'Date de naissance',
                    'class' => 'text'
                ]
            ])
            ->add('adresse', null, [
                'label' => 'Adresse',
                'label_attr' => [
                    'class' => 'label'
                ],
                'attr' => [
                    'placeholder' => 'Adresse',
                    'class' => 'text'
                ]
            ])
            ->add('CP', null, [
                'label' => 'Code postal',
                'label_attr' => [
                    'class' => 'label'
                ],
                'attr' => [
                    'placeholder' => 'Code postal',
                    'class' => 'text'
                ]
            ])
            ->add('ville', null, [
                'label' => 'Ville',
                'label_attr' => [
                    'class' => 'label'
                ],
                'attr' => [
                    'placeholder' => 'Ville',
                    'class' => 'text'
                ]
            ])
            ->add('tel_fix', null, [
                'required' => false, // Ajouté pour éviter l'erreur 'This value should not be blank.
                'label' => 'Téléphone fixe',
                'label_attr' => [
                    'class' => 'label'
                ],
                'attr' => [
                    'placeholder' => 'Téléphone fixe',
                    'class' => 'text'
                ]
            ])
            ->add('tel_port', null, [
                'label' => 'Téléphone portable',
                'label_attr' => [
                    'class' => 'label'
                ],
                'attr' => [
                    'placeholder' => 'Téléphone portable',
                    'class' => 'text'
                ]
            ])
            ->add('avancement', null, [
                'label' => 'Avancement',
                'label_attr' => [
                    'class' => 'label'
                ],
                'attr' => [
                    'placeholder' => 'Avancement',
                    'class' => 'text'
                ]
            ])
            ->add('pupitre', EntityType::class, [
                'label' => 'Pupitre',
                'label_attr' => [
                    'class' => 'label'
                ],
                'attr' => [
                    'class' => 'select'
                ],
                'required' => false,
                'placeholder' => 'Choisir un pupitre',
                'class' => Pupitres::class,
'choice_label' => 'nom',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Eleves::class,
        ]);
    }
}
