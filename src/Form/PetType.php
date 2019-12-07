<?php

namespace App\Form;

use App\Entity\Secondary\Pet;
use App\Form\FormConfig\FormConfig;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PetType extends FormConfig
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name',
        TextType::class,
        $this->getFormConf(true, "Nom", "Tapez le de votre animal"))

        ->add('type',
        TextType::class,
        $this->getFormConf(true, "Type", "Choisissez un type pour votre animal"))

        ->add('race',
        TextType::class,
        $this->getFormConf(true, "Race", "Renseignez la race de votre animal"))

        ->add('birthday', DateType::class, [
            'label' => 'Date d\'aniversaire',
            'widget' => 'single_text',
            'html5' => false
        ])

        ->add('sexe', TextType::class,
        $this->getFormConf(true, "Sexe", "Le sexe de l'animal"))

        ->add('dateacquisition', DateType::class, [
            'label' => 'Date d\'acquisition',
            'widget' => 'single_text',
            'html5' => false
        ])
        ->add('userIduser', EntityType::class, array(
            'class' => 'App\Entity\Secondary\User',
            'label' => 'Le nom du propriétaire',
            'choice_label' => 'firstname',
            'expanded' => false,
            'multiple' => false
        ))
        ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Pet::class,
        ]);
    }
}
