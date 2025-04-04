<?php

namespace App\Form\Auth;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        // TODO: Add recaptcha
        $builder
            ->add('_username', TextType::class, [
                'label' => 'forms.login.fields.username.label',
                'attr' => [
                    'autofocus' => true,
                    'placeholder' => 'forms.login.fields.username.placeholder',
                ],
                'constraints' => [
                    new NotBlank(),
                    new Type('string'),
                    new Email()
                ],
            ])
            ->add('_password', PasswordType::class, [
                'label' => 'forms.login.fields.password.label',
                'attr' => [
                    'placeholder' => 'forms.login.fields.password.placeholder',
                ],
                'row_attr' => [
                    'class' => 'mb-5'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Type('string'),
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'forms.login.fields.submit.label',
                'attr' => [
                    'class' => 'btn btn-primary bg-gradient-primary w-100 mb-0',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'translation_domain' => 'cms'
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}