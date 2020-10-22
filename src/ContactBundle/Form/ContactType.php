<?php

namespace ContactBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Nom... *'
                ],
                'constraints' => [
                    new Length([
                        'min' => 1,
                        'max' => 100,
                    ]),
                    new NotBlank()
                ]
            ])
            ->add('firstname', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Prénom... *'
                ],
                'constraints' => [
                    new Length([
                        'min' => 1,
                        'max' => 100,
                    ]),
                    new NotBlank()
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Email... *'
                ],
                'constraints' => [
                    new Email([
                        'message' => 'Cet email est invalide. Exemple : myname@gmail.com'
                    ])
                ]
            ])
            ->add('phone', TelType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Téléphone... *'
                ],
            ])
            ->add('message', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'rows' => 10,
                    'placeholder' => 'Message... *'
                ],
                'constraints' => [
                    new Length([
                        'min' => 3,
                        'max' => 1000,
                    ]),
                    new NotBlank()
                ]
            ])
            ->add('save', SubmitType::class,  [
                'label' => 'Envoyer',
                'attr' => [
                    'class' => 'btn'
                ]
            ]);
    }
}