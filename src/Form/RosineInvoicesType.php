<?php

namespace App\Form;

use App\Entity\RosineInvoices;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RosineInvoicesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('companyId')
            ->add('invoiceId')
            ->add('invoiceDate')
            ->add('invoiceCustomer')
            ->add('invoiceCustomerPrivate')
            ->add('invoiceAmmount')
            ->add('invoiceAmmountBrutto')
            ->add('invoiceNote')
            ->add('invoiceStatus')
            ->add('invoiceTemplate')
            ->add('invoicePrinted')
            ->add('generated')
            ->add('changed')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RosineInvoices::class,
        ]);
    }
}
