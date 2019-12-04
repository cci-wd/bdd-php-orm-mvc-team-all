<?php

namespace App\Form;

use App\Entity\Section;
use App\Entity\Student;
use App\Form\SkillType;
use App\Form\EducationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
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
                'attr' => [ 'class' => 'dropify'],
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
                'attr' => ['class' => 'form-control input-lg', 'placeholder' => 'Prénom'],
            ])
            ->add('lastName', TextType::class, [
                'attr' => ['class' => 'form-control input-lg', 'placeholder' => 'Nom'],
            ])
            ->add('description', TextType::class, [
                'attr' => ['class' => 'form-control input-lg', 'placeholder' => 'Description', 'row' => 8],
                'required' => false,
            ])
            ->add('location', TextType::class, [
                'attr' => ['class' => 'form-control input-lg', 'placeholder' => 'Ville'],
                'required' => false,
            ])
            ->add('website', TextType::class, [
                'attr' => ['class' => 'form-control input-lg', 'placeholder' => 'URL'],
                'required' => false,
            ])
            ->add('age', TextType::class, [
                'attr' => ['class' => 'form-control input-lg', 'placeholder' => 'Age'],
            ])
            ->add('phoneNumber', TelType::class, [
                'attr' => ['class' => 'form-control input-lg', 'placeholder' => 'Téléphone', 'pattern' => "[0-9]{6}"],
            ])
            ->add('email', TextType::class, [
                'attr' => ['class' => 'form-control input-lg', 'placeholder' => 'Email'],
            ])
            ->add('coverImage', FileType::class, [
                'attr' => ['class' => 'form-control input-lg'],
                'required' => false,
            ])
            ->add('linkedin', TextType::class, [
                'attr' => ['class' => 'form-control input-lg', 'placeholder' => 'Linkedin'],
                'required' => false,
            ])
            ->add('twitter', TextType::class, [
                'attr' => ['class' => 'form-control input-lg', 'placeholder' => 'Twitter'],
                'required' => false,
            ])
            ->add('github', TextType::class, [
                'attr' => ['class' => 'form-control input-lg', 'placeholder' => 'Github'],
                'required' => false,
            ])
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'btn btn-success btn-xl btn-round '],
            ])->add('educations', CollectionType::class, [
                'entry_type' => EducationType::class,
                'entry_options' => ['label' => false],
                'allow_add'=> true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => false
            ])
            ->add('experiences', CollectionType::class, [
                'entry_type' => ExperienceType::class,
                'entry_options' => ['label' => false],
                'allow_add'=> true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => false
            ])
            ->add('skills', CollectionType::class, [
                'entry_type' => SkillType::class,
                'entry_options' => ['label' => false],
                'allow_add'=> true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => false
            ])
            ->add('section', EntityType::class, [
                'class' => Section::class,
                'choice_label' => 'name',
                'placeholder' => "Choisir la section de l'apprenant",
                'attr' => ['class' => 'form-control selectpicker'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
