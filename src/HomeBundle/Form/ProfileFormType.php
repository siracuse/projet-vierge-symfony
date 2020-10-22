<?php

namespace HomeBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\ProfileFormType as BaseProfileFormType;
use Symfony\Component\Validator\Constraints\Length;

class ProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('username')
            ->add('name', TextType::class, [
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'max' => 255,
                        'minMessage' => 'Ce nom est trop court. Il doit avoir 2 caractères minimums',
                        'maxMessage' => 'Ce nom est trop grand. Il doit avoir 255 caractères maximums'
                    ])
                ]
            ])
            ->add('firstname', TextType::class, [
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'max' => 255,
                        'minMessage' => 'Ce nom est trop court. Il doit avoir 2 caractères minimums',
                        'maxMessage' => 'Ce nom est trop grand. Il doit avoir 255 caractères maximums'
                    ])
                ]
            ])
        ;
    }

    public function getParent()
    {
        return BaseProfileFormType::class;
    }

    public function getBlockPrefix()
    {
        return 'app_user_profile';
    }

}