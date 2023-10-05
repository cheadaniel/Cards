<?php

namespace App\Form;

use App\Entity\Card;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CardFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('Artist', TextType::class, [
                'label' => 'Artiste'
            ])
            ->add('Description', TextareaType::class, [
                'label' => 'Description'
            ])
            ->add('Image', TextType::class, [
                'label' => 'Url de l\'image'
            ])
            ->add('Number', TextType::class, [
                'label' => 'Numéro de carte'
            ])
            ->add('Rarity', TextType::class, [
                'label' => 'Rareté'
            ])
            ->add('Type', TextType::class, [
                'label' => 'Type'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Card::class,
        ]);
    }
}
