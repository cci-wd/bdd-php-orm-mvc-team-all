<?php

namespace App\Form;

use App\Entity\Education;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EducationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image', FileType::class, [
                'label' => 'Image de profil',
                'attr' => ['class' => 'dropify'],
                'mapped' => false,
                'required' => false,
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
            ->add('degree', TextType::class, [
                'attr' => [ 'class' => 'form-control', 'placeholder' => 'Diplôme']
            ])
            ->add('speciality', TextType::class, [
                'attr' => [ 'class' => 'form-control', 'placeholder' => 'Spécialité']
            ])
            ->add('schoolName', TextType::class, [
                'attr' => [ 'class' => 'form-control', 'placeholder' => 'Nom de l\'école']
            ])
            ->add('dateFrom', DateType::class, [
                'attr' => [ 'class' => 'form-control', 'placeholder' => 'Date de début'],
                'widget' => 'single_text',
            ])
            ->add('dateTo', DateType::class, [
                'attr' => [ 'class' => 'form-control', 'placeholder' => 'Date de fin'],
                'widget' => 'single_text',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Education::class,
        ]);
    }
}
