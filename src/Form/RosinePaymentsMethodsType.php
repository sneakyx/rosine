<?php

namespace App\Form;

use App\Entity\RosinePaymentsMethods;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RosinePaymentsMethodsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('methName')
            ->add('methNote')
            ->add('generated')
            ->add('changed')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RosinePaymentsMethods::class,
        ]);
    }
}
