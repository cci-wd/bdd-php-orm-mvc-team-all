<?php

namespace App\Form;

use App\Entity\Businesses;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BusinessesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [ 'class' => 'form-control input-lg', 'type' => 'text', 'placeholder' => "Nom de l'entreprise" ],
            ])
            ->add('slogan', TextType::class, [
                'attr' => [ 'class' => 'form-control input-lg', 'type' => 'text', 'placeholder' => "Slogan" ],
            ])
            ->add('minDescription', TextareaType::class, [
                'attr' => ['class' => 'form-control', 'rows' => '3', 'placeholder' => 'Description...'],
            ])
            ->add('image', FileType::class, [
                'attr' => [ 'class' => 'dropify', 'type' => 'file' ],
            ])
            ->add('location', TextType::class, [
                'attr' => [ 'class' => 'form-control', 'type' => 'text', 'placeholder' => "Localisation" ]
            ])
            ->add('nbEmployees', IntegerType::class, [
                'attr' => [ 'class' => 'form-control input-lg', 'type' => 'number', 'placeholder' => 'Nombre d\'employés' ],
            ])
            ->add('website', UrlType::class, [
                'attr' => [ 'class' => 'form-control input-lg', 'type' => 'url', 'placeholder' => "Site Web" ],
            ])
            ->add('dateFoundation', DateType::class, [
                'attr' => [ 'class' => 'form-control', 'type' => 'date', 'placeholder' => "Année de création de l'entreprise" ],
                "widget" => 'single_text',
            ])
            ->add('phoneNumber', TextType::class, [
                'attr' => [ 'class' => 'form-control input-lg', 'type' => 'number', 'placeholder' => "Numéro de téléphone" ],
            ])
            ->add('email', EmailType::class, [
                'attr' => [ 'class' => 'form-control input-lg', 'type' => 'email', 'placeholder' => "Adresse E-mail" ],
            ])
            ->add('facebook', UrlType::class, [
                'attr' => [ 'class' => 'form-control', 'type' => 'url', 'placeholder' => "Profil URL" ],
            ])
            ->add('twitter', UrlType::class, [
                'attr' => [ 'class' => 'form-control', 'type' => 'url', 'placeholder' => "Profil URL" ],
            ])
            ->add('linkedin', UrlType::class, [
                'attr' => [ 'class' => 'form-control', 'type' => 'url', 'placeholder' => "Profil URL" ],
            ])
            ->add('youtube', UrlType::class, [
                'attr' => [ 'class' => 'form-control', 'type' => 'url', 'placeholder' => "Profil URL" ],
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [ 'class' => 'btn btn-success btn-xl btn-round' ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Businesses::class,
        ]);
    }
}
