<?php

namespace App\Form;

use App\Entity\Businesses;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BusinessesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('slogan')
            ->add('minDescription')
            ->add('image')
            ->add('location')
            ->add('nbEmployees')
            ->add('website')
            ->add('dateFoundation')
            ->add('phoneNumber')
            ->add('email')
            ->add('facebook')
            ->add('twitter')
            ->add('linkedin')
            ->add('youtube')
            ->add('description')
            ->add('idUsers')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Businesses::class,
        ]);
    }
}
