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
            ->add('numero_serie')
            ->add('marque')
            ->add('pupitre', EntityType::class, [
                'class' => Pupitres::class,
'choice_label' => 'id',
            ])
            ->add('locataire_musicien', EntityType::class, [
                'class' => User::class,
'choice_label' => 'id',
            ])
            ->add('locataire_eleves', EntityType::class, [
                'class' => Eleves::class,
'choice_label' => 'id',
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
