<?php

namespace App\Form;

use App\Entity\RosineOrders;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RosineOrdersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('companyId')
            ->add('orderId')
            ->add('orderDate')
            ->add('orderCustomer')
            ->add('orderCustomerPrivate')
            ->add('orderAmmount')
            ->add('orderAmmountBrutto')
            ->add('orderNote')
            ->add('orderStatus')
            ->add('orderTemplate')
            ->add('orderPrinted')
            ->add('generated')
            ->add('changed')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RosineOrders::class,
        ]);
    }
}
