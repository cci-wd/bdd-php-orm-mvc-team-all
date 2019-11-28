<?php

namespace App\Form;

use App\Entity\Sections;
use App\Entity\Students;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class StudentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image', FileType::class, [
                'attr' => [ 'class' => 'dropify', 'type' => 'file'],
                'required' => false,
            ])
            ->add('firstName', TextType::class, [
                'attr' => [ 'class' => 'form-control input-lg', 'type' => 'text'],
            ])
            ->add('lastName', TextType::class, [
                'attr' => [ 'class' => 'form-control input-lg', 'type' => 'text'],
            ])
            ->add('minDescription', TextType::class, [
                'attr' => [ 'class' => 'form-control input-lg', 'type' => 'text', 'row'=>8],
                'required' => false,
            ])
            ->add('location', TextType::class, [
                'attr' => [ 'class' => 'form-control input-lg', 'type' => 'text'],
                'required' => false,
            ])
            ->add('website', TextType::class, [
                'attr' => [ 'class' => 'form-control input-lg', 'type' => 'text'],
                'required' => false,
            ])
            ->add('age', TextType::class, [
                'attr' => [ 'class' => 'form-control input-lg', 'type' => 'text'],
            ])
            ->add('phoneNumber', TextType::class, [
                'attr' => [ 'class' => 'form-control input-lg', 'type' => 'text'],
            ])
            ->add('email', TextType::class, [
                'attr' => [ 'class' => 'form-control input-lg', 'type' => 'text'],
            ])
            ->add('coverImage', FileType::class, [
                'attr' => [ 'class' => 'form-control input-lg', 'type' => 'file'],
                'required' => false,
            ])
            // ->add('facebook', TextType::class, [
            //     'attr' => [ 'class' => 'form-control input-lg', 'type' => 'text'],
            //     'required' => false,
            // ])
            ->add('twitter', TextType::class, [
                'attr' => [ 'class' => 'form-control input-lg', 'type' => 'text'],
                'required' => false,
            ])
            ->add('github', TextType::class, [
                'attr' => [ 'class' => 'form-control input-lg', 'type' => 'text'],
                'required' => false,
            ])
            // ->add('youtube', TextType::class, [
            //     'attr' => [ 'class' => 'form-control input-lg', 'type' => 'text'],
            //     'required' => false,
            // ])
            // ->add('sections', EntityType::class, [
            //     'class' => Sections::class,
            //     'choice_label' => 'name',
            //     'attr' => [
            //         'class' => 'form-control selectpicker'
            //     ]
            // ])
            ->add('submit', SubmitType::class, [
                'attr' => [ 'class' => 'btn btn-success btn-xl btn-round ', 'type' => 'submit'],
            ])
            // ->add('users', TextType::class, [
            //     'attr' => [ 'class' => 'form-control input-lg', 'type' => 'text']
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Students::class,
        ]);
    }
}
