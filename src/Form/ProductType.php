<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // Product Name
            ->add('name', TextType::class, [

                // Label
                // --

                // Label text
                'label' => "Nom du produit",

                // Label Attributes
                'label_attr' => [
                    'class' => "",
                ],


                // Is required
                // --

                'required' => true,


                // Fields Attributes
                // --

                'attr' => [
                    'class' => "",
                    'placeholder' => "Saisir le nom du produit",
                ],


                // Helper
                // --

                'help' => "Le nom du produit sera affiché publiquement.",
                'help_attr' => [
                    'class' => "",
                ],


                // Constraints
                // --

                'constraints' => [
                    new NotBlank([
                        'message' => "Le nom du produit est obligatoire."
                    ])
                ],

            ])


            // Product Description
            ->add('description', TextareaType::class, [

                // Label
                // --

                // Label text
                'label' => "Description du produit",

                // Label Attributes
                'label_attr' => [
                    'class' => "",
                ],


                // Is required
                // --

                'required' => false,


                // Fields Attributes
                // --

                'attr' => [
                    'class' => "",
                    'placeholder' => "Saisir la description du produit",
                ],


                // Helper
                // --

                'help' => "Le description du produit sera affiché publiquement.",
                'help_attr' => [
                    'class' => "",
                ],


                // Constraints
                // --

                'constraints' => [
                    new Length([
                        'max' => 1000, // 1000 caractère max
                        'maxMessage' => "La description ne doit pas dépasser 1000 caractères"
                    ])
                ],

            ])


            // Product Price
            ->add('price', MoneyType::class, [

                // Label
                // --

                // Label text
                'label' => "Prix du produit",

                // Label Attributes
                'label_attr' => [
                    'class' => "",
                ],


                // Is required
                // --

                'required' => true,


                // Fields Attributes
                // --

                'attr' => [
                    'class' => "",
                    'placeholder' => "Saisir le prix du produit",
                ],


                // Helper
                // --

                'help' => "Le prix du produit sera affiché publiquement.",
                'help_attr' => [
                    'class' => "",
                ],


                // Constraints
                // --

                'constraints' => [
                    new NotBlank([
                        'message' => "Le prix est obligatoire."
                    ]),
                    new GreaterThan([
                        'value' => 0,
                        'message' => "Le prix doit etre supérieur à zero &#128;"
                    ]),
                    new LessThanOrEqual([
                        'value' => 9999.99,
                        'message' => "Les-prix doir être inférieur à 9999.99 &euro;"
                    ])
                ],

            ])


            // Product Illustration
            // ->add('illustration')


            // Product Categories
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}