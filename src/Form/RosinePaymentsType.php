<?php

namespace App\Form;

use App\Entity\RosinePayments;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RosinePaymentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('companyId')
            ->add('paymentId')
            ->add('invoiceId')
            ->add('paymentDate')
            ->add('methId')
            ->add('paymentAmmount')
            ->add('paymentNote')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RosinePayments::class,
        ]);
    }
}
