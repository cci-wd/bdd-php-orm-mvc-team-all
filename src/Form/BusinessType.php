<?php

namespace App\Form;

use App\Entity\Business;
use App\Repository\CityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class BusinessType extends AbstractType
{
    private $userRepository;

    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    public function getAllCityName()
    {
        $names = [];
        foreach ($this->cityRepository->findAllCityAlphabetical() as $city) {
            $names[$city->getName()] = $city->getName();
        }
        return $names;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => ['class' => 'form-control input-lg', 'placeholder' => "Nom de l'entreprise"],
            ])
            ->add('slogan', TextType::class, [
                'attr' => ['class' => 'form-control input-lg', 'placeholder' => "Slogan"],
                'required' => false,
            ])
            ->add('description', TextareaType::class, [
                'attr' => ['class' => 'form-control', 'rows' => '3', 'placeholder' => 'Description...'],
                'required' => false,
            ])
            ->add('image', FileType::class, [
                'label' => 'Image de profil',
                'attr' => ['class' => 'dropify'],
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
            ->add('location', ChoiceType::class, [
                'placeholder' => 'Commune',
                'choices' => $this->getAllCityName(),
                'attr' => ['class' => 'form-control selectpicker custom-picker-location'],
                'required' => false,
            ])
            ->add('nbEmployees', IntegerType::class, [
                'attr' => ['class' => 'form-control input-lg', 'min' => '1', 'placeholder' => 'Nombre d\'employés'],
                'required' => false,
            ])
            ->add('website', UrlType::class, [
                'attr' => ['class' => 'form-control input-lg', 'placeholder' => "Site Web"],
                'required' => false,
            ])
            ->add('dateFoundation', DateType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => "Année de création de l'entreprise"],
                "widget" => 'single_text',
                'required' => false,
            ])
            ->add('phoneNumber', TextType::class, [
                'attr' => ['class' => 'form-control input-lg', 'placeholder' => "Numéro de téléphone"],
            ])
            ->add('email', EmailType::class, [
                'attr' => ['class' => 'form-control input-lg', 'placeholder' => "Adresse E-mail"],
            ])
            ->add('facebook', UrlType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => "URL Facebook"],
                'required' => false,
            ])
            ->add('twitter', UrlType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => "URL Twitter"],
                'required' => false,
            ])
            ->add('linkedin', UrlType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => "URL Linkedin"],
                'required' => false,
            ])
            ->add('youtube', UrlType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => "URL Youtube"],
                'required' => false,
            ])
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'btn btn-success btn-xl btn-round'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Business::class,
        ]);
    }
}
