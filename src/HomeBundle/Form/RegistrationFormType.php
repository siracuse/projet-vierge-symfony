<?php

namespace HomeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseRegistrationFormType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('username')
            ->remove('plainPassword')
            ->remove('email')
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'options' => array(
                    'translation_domain' => 'FOSUserBundle',
                    'attr' => array(
                        'autocomplete' => 'new-password',
                    ),
                ),
                'first_options' => array('label' => 'form.password'),
                'second_options' => array('label' => 'form.password_confirmation'),
                'invalid_message' => 'fos_user.password.mismatch',
                'constraints' => [
                    new Regex([
                        'pattern' => '#(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,}#',
                        'message' => 'Votre mot de passe doit avoir au minimum 8 caractères avec au moins : 1 minuscule, 1 majuscule et 1 chiffre'
                    ])
                ]
            ))
            ->add('name', TextType::class, [
                'label' => 'Nom',
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
                'label' => 'Prénom',
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'max' => 255,
                        'minMessage' => 'Ce prénom est trop court. Il doit avoir 2 caractères minimums',
                        'maxMessage' => 'Ce prénom est trop grand. Il doit avoir 255 caractères maximums'
                    ])
                ]
            ])
            ->add('email', EmailType::class, array(
                'label' => 'form.email',
                'translation_domain' => 'FOSUserBundle',
                'constraints' => [
                    new Regex([
                        'pattern' => '#^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$#',
                        'message' => 'L\'adresse email saisie est incorrecte'
                    ])
                ]
            ))
        ;
    }

    public function getParent()
    {
        return BaseRegistrationFormType::class;
    }
}