<?php

namespace App\Form;

use App\Entity\RosineArticles;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RosineArticlesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('artName')
            ->add('artUnit')
            ->add('artPrice')
            ->add('artTax')
            ->add('artStocknr')
            ->add('artInstock')
            ->add('artNote')
            ->add('generated')
            ->add('changed')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RosineArticles::class,
        ]);
    }
}
