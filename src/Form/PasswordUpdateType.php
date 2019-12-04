<?php

namespace App\Form;

use App\Form\FormConfig\FormConfig;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PasswordUpdateType extends FormConfig
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'oldPassword',
                PasswordType::class, $this->getFormConf(true, 'Votre ancien mot de passe', 'Tapez votre mot de passe actuel'))
            ->add('newPassword',
                PasswordType::class, $this->getFormConf(true, 'Votre nouveau mot de passe', 'Donnez votre nouveau mot de passe actuel'))
            ->add('confirmPassword',
                PasswordType::class, $this->getFormConf(true, 'Confirmation', 'Confirmez votre nouveau mot de passe'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
