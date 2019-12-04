<?php

namespace App\Form;

use App\Entity\Main\AdminUser;
use App\Form\FormConfig\FormConfig;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends FormConfig
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName',
                TextType::class,
                $this->getFormConf(true, "Prénom", "Votre prénom")
            )
            ->add('lastName',
                TextType::class,
                $this->getFormConf(true, "Nom", "Votre nom de famille")
            )
            ->add('email',
                EmailType::class,
                $this->getFormConf(true, "Email", "Votre adresse email")
            )
            ->add('hash',
                PasswordType::class,
                $this->getFormConf(true, "Mot de passe", "Tapez votre mot de passe")
            )
            ->add('passwordConfirm',
                PasswordType::class,
                $this->getFormConf(true, "Confirmation", "Merci de confirmer votre mot de passe")
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AdminUser::class,
        ]);
    }
}
