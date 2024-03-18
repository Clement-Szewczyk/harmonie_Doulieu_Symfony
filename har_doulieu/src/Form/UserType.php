<?php

namespace App\Form;

use App\Entity\Pupitres;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo', null, [
                'label' => 'Pseudo',
                'label_attr' => [
                    'class' => 'label'
                ],
                'attr' => [
                    'placeholder' => 'Pseudo',
                    'class' => 'text'
                ]
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Musicien' => 'ROLE_USER',
                    'Administrateur' => 'ROLE_ADMIN',
                ],
                'multiple' => true,
                'expanded' => true,
            ], [
                'label' => 'Rôle',
                'label_attr' => [
                    'class' => 'label'
                ],
            ])
            ->add('password', null, [
                'label' => 'Mot de passe',
                'label_attr' => [
                    'class' => 'label'
                ],
                'attr' => [
                    'placeholder' => 'Mot de passe',
                    'class' => 'text'
                ]
            ])
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
            ->add('tel_fixe', null, [
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
            ->add('date_naissance', null, [
                'label' => 'Date de naissance',
                'label_attr' => [
                    'class' => 'label'
                ],
                'attr' => [
                    'placeholder' => 'Date de naissance',
                    'class' => 'text'
                ]
            ])
            ->add('date_har' , null, [
                'label' => 'Date d\'adhésion',
                'label_attr' => [
                    'class' => 'label'
                ],
                'attr' => [
                    'placeholder' => 'Date d\'adhésion',
                    'class' => 'text'
                ]
            ])
            ->add('date_fede' , null, [
                'label' => 'Date de fédération',
                'label_attr' => [
                    'class' => 'label'
                ],
                'attr' => [
                    'placeholder' => 'Date de fédération',
                    'class' => 'text'
                ]
            ])
            ->add('role')
            ->add('ville')
            ->add('pupitre', EntityType::class, [
                'class' => Pupitres::class,
'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
