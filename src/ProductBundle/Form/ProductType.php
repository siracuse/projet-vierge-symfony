<?php

namespace ProductBundle\Form;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du produit* :',
                'constraints' => [
                    new Length([
                        'max' => 255
                    ]),
                    new NotBlank()
                ]
            ])
            ->add('description', CKEditorType::class, [
                'label' => 'Description* :',
                'constraints' => [
                    new Length([
                        'max' => 20000
                    ]),
                    new NotBlank()
                ]
            ])
            ->add('price', MoneyType::class, [
                'label'=> 'Prix',
            ])
            ->add('images', FileType::class, [
                'multiple' => true,
                'mapped' => false,
                'required' => false,
                'data_class' => null,
                'attr' => [
                    'accept' => '.jpg, .jpeg, .png'
                ],
                'label' => 'Images* : ',
                "constraints" => [
                    new All([
                        new File([
                            "maxSize" => "2M",
                            "mimeTypes" => [
                                "image/png",
                                "image/jpg",
                                "image/jpeg"
                            ],
                        ])
                    ])
                ]
            ])
            ->add('category', EntityType::class, [
                'class' => 'ProductBundle\Entity\Category',
                'choice_label' => 'name'
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Valider',
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ProductBundle\Entity\Product'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'productbundle_product';
    }


}
