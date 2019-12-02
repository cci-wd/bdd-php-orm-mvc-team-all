<?php

namespace App\Form;

use App\Entity\Student;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\File;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image', FileType::class, [
                'label' => 'Image de profil',
                'attr' => [ 'class' => 'dropify', 'type' => 'file'],
                // unmapped means that this field is not associated to any entity property
                'mapped' => false,
                // make it optional so you don't have to re-upload the PDF file
                // everytime you edit the Product details
                'required' => false,
                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                            'image/jpg',
                        ],
                        'mimeTypesMessage' => 'Image non valide.',
                    ]),
                ],
            ])
            ->add('firstName', TextType::class, [
                'attr' => ['class' => 'form-control input-lg', 'type' => 'text'],
            ])
            ->add('lastName', TextType::class, [
                'attr' => ['class' => 'form-control input-lg', 'type' => 'text'],
            ])
            ->add('minDescription', TextType::class, [
                'attr' => ['class' => 'form-control input-lg', 'type' => 'text', 'row' => 8],
                'required' => false,
            ])
            ->add('location', TextType::class, [
                'attr' => ['class' => 'form-control input-lg', 'type' => 'text'],
                'required' => false,
            ])
            ->add('website', TextType::class, [
                'attr' => ['class' => 'form-control input-lg', 'type' => 'text'],
                'required' => false,
            ])
            ->add('age', TextType::class, [
                'attr' => ['class' => 'form-control input-lg', 'type' => 'text'],
            ])
            ->add('phoneNumber', TextType::class, [
                'attr' => ['class' => 'form-control input-lg', 'type' => 'text'],
            ])
            ->add('email', TextType::class, [
                'attr' => ['class' => 'form-control input-lg', 'type' => 'text'],
            ])
            ->add('coverImage', FileType::class, [
                'attr' => ['class' => 'form-control input-lg', 'type' => 'file'],
                'required' => false,
            ])
            // ->add('facebook', TextType::class, [
            //     'attr' => [ 'class' => 'form-control input-lg', 'type' => 'text'],
            //     'required' => false,
            // ])
            ->add('twitter', TextType::class, [
                'attr' => ['class' => 'form-control input-lg', 'type' => 'text'],
                'required' => false,
            ])
            ->add('github', TextType::class, [
                'attr' => ['class' => 'form-control input-lg', 'type' => 'text'],
                'required' => false,
            ])
            // ->add('youtube', TextType::class, [
            //     'attr' => [ 'class' => 'form-control input-lg', 'type' => 'text'],
            //     'required' => false,
            // ])
            // ->add('section', EntityType::class, [
            //     'class' => Section::class,
            //     'choice_label' => 'name',
            //     'attr' => [
            //         'class' => 'form-control selectpicker'
            //     ]
            // ])
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'btn btn-success btn-xl btn-round ', 'type' => 'submit'],
            ])
            // ->add('users', TextType::class, [
            //     'attr' => [ 'class' => 'form-control input-lg', 'type' => 'text']
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
