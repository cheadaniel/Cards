<?php

namespace App\Form;

use App\Entity\Extension;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExtensionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('ReleaseDate', DateTimeType::class, array(
                'input' => 'datetime_immutable',
                'label' => "Date de sortie",
                'widget' => 'single_text',
            ))
            ->add('Image', TextType::class, [
                'label' => 'Url de l\'image'
            ])
            ->add("Envoyer", SubmitType::class, [
                'label' => 'Créer',
                'attr' => [
                    'class' => 'btn',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Extension::class,
        ]);
    }
}
