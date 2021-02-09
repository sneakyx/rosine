<?php

namespace App\Form;

use App\Entity\RosineOffersPositions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RosineOffersPositionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('companyId')
            ->add('offerId')
            ->add('posiId')
            ->add('artNumber')
            ->add('posiAmmount')
            ->add('posiUnit')
            ->add('posiPrice')
            ->add('posiLocation')
            ->add('posiSerial')
            ->add('posiText')
            ->add('posiTax')
            ->add('done')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RosineOffersPositions::class,
        ]);
    }
}
