<?php

namespace App\Form;

use App\Entity\RosineTaxes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RosineTaxesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('taxName')
            ->add('taxPercentage')
            ->add('generated')
            ->add('changed')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RosineTaxes::class,
        ]);
    }
}
