<?php

namespace App\Form;

use App\Entity\Offers;
use App\Entity\Sections;
use App\Entity\Businesses;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class OffersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [ 'class' => 'form-control input-lg', 'type' => 'text', 'placeholder' => "Titre de l'annonce", 'autocomplete' => 'off']
            ])
            ->add('minDescription', TextareaType::class, [
                'attr' => ['class' => 'form-control', 'rows' => '3', 'placeholder' => 'Description...']
            ])
            ->add('site', TextType::class, [
                'attr' => [ 'class' => 'form-control', 'type' => 'text', 'placeholder' => "URL site Web", 'autocomplete' => 'off']
            ])
            ->add('location', TextType::class, [
                'attr' => [ 'class' => 'form-control', 'type' => 'text', 'placeholder' => "Adresse"]
            ])
            ->add('hoursWeek', IntegerType::class, [
                'attr' => [ 'class' => 'form-control', 'type' => 'text', 'min' => '1', 'placeholder' => "Volume horaire", 'autocomplete' => 'off']
            ])
            ->add('description', TextareaType::class, [
                'attr' => ['class' => 'summernote-editor', 'rows' => '3', 'placeholder' => "Description"]
            ])
            ->add('sections', EntityType::class, [
                'class' => Sections::class,
                'choice_label' => 'name',
                'placeholder' => 'Choisir votre section',
                'attr' => ['class' => 'form-control selectpicker']
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [ 'class' => 'btn btn-success btn-xl btn-round' ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Offers::class,
        ]);
    }
}
