<?php

namespace App\Form;

use App\Entity\RosineDeliveries;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RosineDeliveriesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('companyId')
            ->add('deliveryId')
            ->add('deliveryDate')
            ->add('deliveryCustomer')
            ->add('deliveryCustomerPrivate')
            ->add('deliveryAmmount')
            ->add('deliveryAmmountBrutto')
            ->add('deliveryNote')
            ->add('deliveryStatus')
            ->add('deliveryTemplate')
            ->add('deliveryPrinted')
            ->add('generated')
            ->add('changed')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RosineDeliveries::class,
        ]);
    }
}
