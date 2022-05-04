<?php

namespace App\Form;

use App\Entity\Brand;
use App\Entity\Car;
use App\Entity\Energy;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, ["label" => "Titre de l'annonce"])
            ->add('description', TextareaType::class, ["label" => "Détail de l'annonce"])
            ->add('brand', EntityType::class, ["class" => Brand::class, "label" => "Marque"])
            ->add('model', TextType::class, ["label" => "Modèle"])
            ->add('Energy', EntityType::class, ["class" => Energy::class, "label" => "Energie"])
            ->add('price', NumberType::class, ["label" => "Prix"])
            ->add('releaseYear', TextType::class, ["label" => "Année de construction"])
            ->add('km', IntegerType::class, ["label" => "Kilométrage"])
            ->add('licenceDriver', CheckboxType::class, ["label" => "Avec permis", "required" => false, "attr" => ["checked" => true]])
            ->add('photoUpload', FileType::class, ["label" => "Photo", "required" => false, "mapped" => false, 'constraints' => [new File([
                'maxSize' => '5360k',
                'maxSizeMessage' => 'Taille du fichier trop importante',
                'mimeTypes' => ['image/jpeg', 'image/png'], 'mimeTypesMessage' => 'Merci de téléverser une image JPEG ou PNG'
            ])]])
            ->add('active', HiddenType::class, ["attr" => ["checked" => true]]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
