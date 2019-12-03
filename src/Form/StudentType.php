<?php

namespace App\Form;

use App\Entity\Student;
use App\Form\SkillType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

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
                'attr' => ['class' => 'form-control input-lg', 'type' => 'text', 'placeholder' => 'Prénom'],
            ])
            ->add('lastName', TextType::class, [
                'attr' => ['class' => 'form-control input-lg', 'type' => 'text', 'placeholder' => 'Nom'],
            ])
            ->add('minDescription', TextType::class, [
                'attr' => ['class' => 'form-control input-lg', 'type' => 'text', 'row' => 8, 'placeholder' => 'Description'],
                'required' => false,
            ])
            ->add('location', TextType::class, [
                'attr' => ['class' => 'form-control input-lg', 'type' => 'text','placeholder' => 'Ville'],
                'required' => false,
            ])
            ->add('website', TextType::class, [
                'attr' => ['class' => 'form-control input-lg', 'type' => 'text','placeholder' => 'URL'],
                'required' => false,
            ])
            ->add('age', TextType::class, [
                'attr' => ['class' => 'form-control input-lg', 'type' => 'text','placeholder' => 'Age'],
            ])
            ->add('phoneNumber', TextType::class, [
                'attr' => ['class' => 'form-control input-lg', 'type' => 'text','placeholder' => 'Téléphone'],
            ])
            ->add('email', TextType::class, [
                'attr' => ['class' => 'form-control input-lg', 'type' => 'text', 'placeholder' => 'Email'],
            ])
            ->add('coverImage', FileType::class, [
                'attr' => ['class' => 'form-control input-lg', 'type' => 'file'],
                'required' => false,
            ])
            ->add('linkedin', TextType::class, [
                'attr' => ['class' => 'form-control input-lg', 'type' => 'text', 'placeholder' => 'Linkedin'],
                'required' => false,
            ])
            ->add('twitter', TextType::class, [
                'attr' => ['class' => 'form-control input-lg', 'type' => 'text', 'placeholder' => 'Twitter'],
                'required' => false,
            ])
            ->add('github', TextType::class, [
                'attr' => ['class' => 'form-control input-lg', 'type' => 'text', 'placeholder' => 'Github'],
                'required' => false,
            ])
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'btn btn-success btn-xl btn-round ', 'type' => 'submit'],
            ])->add('skills', CollectionType::class, [
                'entry_type' => SkillType::class,
                'entry_options' => ['label' => false],
                'allow_add'=> true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
