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
            ->add('password',
                TextType::class,
                $this->getFormConf(true, "Mot de passe", "Tapez votre mot de passe")
            )
            ->add('street',
                TextType::class,
                $this->getFormConf(true, "Rue", "Le nom de votre rue")
            )
            ->add('zip',
                PasswordType::class,
                $this->getFormConf(true, "Code postal", "Le code postal de votre ville")
            )
            ->add('city',
                TextType::class,
                $this->getFormConf(true, "Ville", "Le nom de votre ville")
            )
            ->add('country',
                TextType::class,
                $this->getFormConf(true, "Pays", "Entrez le nom de votre pays")
            )
            ->add('sexe',
                TextType::class,
                $this->getFormConf(true, "Sexe", "Le nom de votre rue")
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
