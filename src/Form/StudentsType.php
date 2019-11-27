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
            ->add('name')
            ->add('minDescription')
            ->add('location')
            ->add('website')
            ->add('age')
            ->add('phoneNumber')
            ->add('email')
            ->add('coverImage')
            ->add('facebook')
            ->add('twitter')
            ->add('github')
            ->add('idSections')
            ->add('idUsers')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Students::class,
        ]);
    }
}
