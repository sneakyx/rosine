<?php

namespace App\Form;

use App\Entity\Customer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('contactTid')
            ->add('contactOwner')
            ->add('contactPrivate')
            ->add('catId')
            ->add('nFamily')
            ->add('nGiven')
            ->add('nMiddle')
            ->add('nPrefix')
            ->add('nSuffix')
            ->add('nFn')
            ->add('nFileas')
            ->add('contactBday')
            ->add('orgName')
            ->add('orgUnit')
            ->add('contactTitle')
            ->add('contactRole')
            ->add('contactAssistent')
            ->add('contactRoom')
            ->add('adrOneStreet')
            ->add('adrOneStreet2')
            ->add('adrOneLocality')
            ->add('adrOneRegion')
            ->add('adrOnePostalcode')
            ->add('adrOneCountryname')
            ->add('contactLabel')
            ->add('adrTwoStreet')
            ->add('adrTwoStreet2')
            ->add('adrTwoLocality')
            ->add('adrTwoRegion')
            ->add('adrTwoPostalcode')
            ->add('adrTwoCountryname')
            ->add('telWork')
            ->add('telCell')
            ->add('telFax')
            ->add('telAssistent')
            ->add('telCar')
            ->add('telPager')
            ->add('telHome')
            ->add('telFaxHome')
            ->add('telCellPrivate')
            ->add('telOther')
            ->add('telPrefer')
            ->add('contactEmail')
            ->add('contactEmailHome')
            ->add('contactUrl')
            ->add('contactUrlHome')
            ->add('contactFreebusyUri')
            ->add('contactCalendarUri')
            ->add('contactNote')
            ->add('contactTz')
            ->add('contactGeo')
            ->add('contactPubkey')
            ->add('contactCreated')
            ->add('contactCreator')
            ->add('contactModified')
            ->add('contactModifier')
            ->add('accountId')
            ->add('contactEtag')
            ->add('contactUid')
            ->add('adrOneCountrycode')
            ->add('adrTwoCountrycode')
            ->add('carddavName')
            ->add('contactFiles')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Customer::class,
        ]);
    }
}
