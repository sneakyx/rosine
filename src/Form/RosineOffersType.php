<?php

namespace App\Form;

use App\Entity\RosineOffers;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RosineOffersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('companyId')
            ->add('offerId')
            ->add('offerDate')
            ->add('offerCustomer')
            ->add('offerCustomerPrivate')
            ->add('offerAmmount')
            ->add('offerAmmountBrutto')
            ->add('offerNote')
            ->add('offerStatus')
            ->add('offerTemplate')
            ->add('offerPrinted')
            ->add('generated')
            ->add('changed')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RosineOffers::class,
        ]);
    }
}
