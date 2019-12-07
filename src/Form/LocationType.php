<?php

namespace App\Form;

use App\Entity\Secondary\Location;
use App\Form\FormConfig\FormConfig;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class LocationType extends FormConfig
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('lon',
        TextType::class,
        $this->getFormConf(true, "Longitude", "Entrez une longitude"))

        ->add('lat',
        TextType::class,
        $this->getFormConf(true, "Latitude", "Entrez une latitude"))

        ->add('petIdpet', EntityType::class, array(
            'class' => 'App\Entity\Secondary\Pet',
            'label' => 'Animal concerné',
            'choice_label' => 'name',
            'expanded' => false,
            'multiple' => false
        ))
        ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
