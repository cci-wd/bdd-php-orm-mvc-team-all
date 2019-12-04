<?php

namespace App\Form;

use App\Entity\Experience;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ExperienceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image', FileType::class, [
                'label' => 'Image de profil',
                'attr' => [ 'class' => 'dropify'],
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
            ->add('title', TextType::class, [
                'attr' => [ 'class' => 'form-control', 'placeholder' => 'Nom de l\'entreprise']
            ])
            ->add('post', TextType::class, [
                'attr' => [ 'class' => 'form-control', 'placeholder' => 'Poste occupé']
            ])
            ->add('dateFrom', DateType::class, [
                'widget' => 'single_text',
                'attr' => [ 'class' => 'form-control', 'placeholder' => 'Date de début']
            ])
            ->add('dateTo', DateType::class, [
                'widget' => 'single_text',
                'attr' => [ 'class' => 'form-control', 'placeholder' => 'Date de fin']
            ])
            ->add('description', TextareaType::class, [
                'attr' => [ 'class' => 'form-control', 'rows' => '3', 'placeholder' => 'Description']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Experience::class,
        ]);
    }
}
