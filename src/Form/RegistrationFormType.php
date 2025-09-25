<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Identifiant',
                'constraints' => [
                    new Assert\NotBlank(['message' => 'L’identifiant est obligatoire']),
                    new Assert\Length([
                        'min' => 3,
                        'minMessage' => 'L’identifiant doit contenir au moins {{ limit }} caractères',
                        'max' => 180,
                    ]),
                ],
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le prénom est obligatoire']),
                    new Assert\Length(['min' => 2, 'max' => 100]),
                ],
            ])
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le nom est obligatoire']),
                    new Assert\Length(['min' => 2, 'max' => 100]),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse email',
                'constraints' => [
                    new Assert\NotBlank(['message' => 'L’email est obligatoire']),
                    new Assert\Email(['message' => 'Veuillez entrer une adresse email valide']),
                ],
            ])
            ->add('sexe', ChoiceType::class, [
                'label' => 'Sexe',
                'choices' => [
                    'Homme' => 'Homme',
                    'Femme' => 'Femme',
                    'Autre' => 'Autre',
                ],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le sexe est obligatoire']),
                ],
            ])
            ->add('dateDeNaissance', DateType::class, [
                'label' => 'Date de naissance',
                'widget' => 'single_text',
                'constraints' => [
                    new Assert\NotBlank(['message' => 'La date de naissance est obligatoire']),
                    new Assert\LessThan('today'),
                    new Assert\GreaterThan('-120 years'),
                ],
            ])
            ->add('numTelephone', TextType::class, [
                'label' => 'Téléphone',
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le numéro de téléphone est obligatoire']),
                    new Assert\Regex([
                        'pattern' => '/^0[1-9](\d{2}){4}$/',
                        'message' => 'Numéro de téléphone invalide (format FR attendu)',
                    ]),
                ],
            ])
            ->add('numSecu', TextType::class, [
                'label' => 'Numéro de sécurité sociale',
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le numéro de sécurité sociale est obligatoire']),
                    new Assert\Regex([
                        'pattern' => '/^\d{15}$/',
                        'message' => 'Le numéro de sécurité sociale doit contenir exactement 15 chiffres',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Mot de passe',
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le mot de passe est obligatoire']),
                    new Assert\Length([
                        'min' => 6,
                        'minMessage' => 'Le mot de passe doit contenir au moins {{ limit }} caractères',
                        'max' => 4096,
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).+$/',
                        'message' => 'Le mot de passe doit contenir au moins 1 majuscule, 1 minuscule, 1 chiffre et 1 caractère spécial',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
