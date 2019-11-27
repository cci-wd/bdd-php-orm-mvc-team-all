<?php

namespace App\Form;

use App\Entity\Students;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image')
            ->add('firstName')
            ->add('lastName')
            ->add('minDescription')
            ->add('location')
            ->add('website')
            ->add('age')
            ->add('phoneNumber')
            ->add('email')
            ->add('coverImage')
            ->add('twitter')
            ->add('github')
            ->add('sections')
            ->add('users')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Students::class,
        ]);
    }
}
