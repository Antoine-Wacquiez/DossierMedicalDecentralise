<?php

namespace App\Form;

use App\Entity\DossierMedical;
use App\Entity\GrpSanguin;
use App\Entity\Allergies;
use App\Entity\Traitements;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class DossierMedicalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Notes médicales
            ->add('notes', TextareaType::class, [
                'label' => 'Notes médicales',
                'required' => false,
                'attr' => [
                    'rows' => 6,
                    'placeholder' => 'Ex : suivi HTA, diabète, antécédents...'
                ],
            ])

            // Groupe sanguin (radio boutons)
            ->add('groupeSanguin', EntityType::class, [
                'class' => GrpSanguin::class,
                'choice_label' => 'libelle',
                'label' => 'Groupe sanguin',
                'required' => false,
                'multiple' => false,
                'expanded' => true, // ✅ radio boutons
            ])

            // Allergies (cases à cocher multiples)
            ->add('allergies', EntityType::class, [
                'class' => Allergies::class,
                'choice_label' => 'libelle',
                'label' => 'Allergies',
                'required' => false,
                'multiple' => true,
                'expanded' => true, // ✅ cases à cocher
                'by_reference' => false,
            ])

            // Traitements (cases à cocher multiples)
            ->add('traitements', EntityType::class, [
                'class' => Traitements::class,
                'choice_label' => function (Traitements $t) {
                    return sprintf(
                        '%s (%d/j - %d j)',
                        $t->getLibelle(),
                        $t->getQteJour(),
                        $t->getDuree()
                    );
                },
                'label' => 'Traitements',
                'required' => false,
                'multiple' => true,
                'expanded' => true, // ✅ cases à cocher
                'by_reference' => false,
            ]); 
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DossierMedical::class,
        ]);
    }
}
