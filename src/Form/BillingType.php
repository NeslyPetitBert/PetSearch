<?php

namespace App\Form;

use App\Entity\Secondary\Billing;
use App\Form\FormConfig\FormConfig;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Doctrine\DBAL\Types\FloatType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class BillingType extends FormConfig
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('datebilling', DateTimeType::class, [
            'widget' => 'single_text',
            'html5' => false
        ])
        ->add('amount', NumberType::class,$this->getFormConf(false, "Montant", "Le montant de la facture"))
        ->add(
            'userIduser', EntityType::class, array(
                'class' => 'App\Entity\Secondary\User',
                'label' => 'Client',
                'choice_label' => 'fullname',
                'expanded' => false,
                'multiple' => false
            ))
    ;
}


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Billing::class,
        ]);
    }
}
