<?php

namespace App\Form;

use App\Entity\Main\AdminUser;
use App\Form\FormConfig\FormConfig;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminRegistrationType extends FormConfig
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName',
                TextType::class,
                $this->getFormConf(true, "Prénom", "Tapez le prénom de l'utilisateur")
            )
            ->add('lastName',
                TextType::class,
                $this->getFormConf(true, "Nom", "Tapez le nom de l'utilisateur")
            )
            ->add('email',
                EmailType::class,
                $this->getFormConf(true, "Email", "Tapez l'email de l'utilisateur")
            )
            ->add('hash',
                PasswordType::class,
                $this->getFormConf(true, "Mot de passe", "Choisissez un mot de passe")
            )
            ->add('passwordConfirm',
                PasswordType::class,
                $this->getFormConf(true, "Confirmation de mot de passe", "Confirmez le mot de passe")
            )
            ->add('roles', ChoiceType::class, [
                'multiple' => true,
                'expanded' => true,
                'choices' => [
                    'Utilisateur' => 'ROLE_USER',
                    'Admin' => 'ROLE_ADMIN',
                    'Développeur' => 'ROLE_DEVELOPER',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AdminUser::class,
        ]);
    }
}