<?php

namespace App\Form;

use App\Entity\Offers;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\Sections;

class OffersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [ 'class' => 'form-control input-lg', 'type' => 'text', 'placeholder' => "Titre de l'annonce"]
            ])
            ->add('minDescription', TextareaType::class, [
                'attr' => ['class' => 'form-control', 'rows' => '3', 'placeholder' => 'Description...']
            ])
            ->add('site', TextType::class, [
                'attr' => [ 'class' => 'form-control', 'type' => 'text', 'placeholder' => "URL site Web"]
            ])
            ->add('location', TextType::class, [
                'attr' => [ 'class' => 'form-control', 'type' => 'text', 'placeholder' => "Adresse"]
            ])
            ->add('hoursWeek', TextType::class, [
                'attr' => [ 'class' => 'form-control', 'type' => 'text', 'placeholder' => "Volume horaire"]
            ])
            ->add('description', TextareaType::class, [
                'attr' => ['class' => 'summernote-editor', 'rows' => '3', 'placeholder' => "Description"]
            ])
            ->add('idBusinesses')
            ->add('idSections', EntityType::class, [
                'class' => Sections::class,
                'choice_label' => 'name',
                'placeholder' => 'Section',
                'attr' => [
                    'class' => 'form-control selectpicker'
                ]
            ])
            ->add('status')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Offers::class,
        ]);
    }
}
