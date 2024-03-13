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
            ->add('nom')
            ->add('prenom')
            ->add('email')
            ->add('date_naissance')
            ->add('adresse')
            ->add('CP')
            ->add('ville')
            ->add('tel_fix')
            ->add('tel_port')
            ->add('avancement')
            ->add('pupitre', EntityType::class, [
                'class' => Pupitres::class,
'choice_label' => 'id',
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
