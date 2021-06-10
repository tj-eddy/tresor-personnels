<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ChangePasswordFormType extends AbstractType
{
    private $_translator;

    /**
     * PpApprovisionementDirecteType constructor.
     */
    public function __construct()
    {
        $this->_translator = new Translator(\Locale::getDefault());
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', RepeatedType::class, [
                'type'            => PasswordType::class,
                'first_options'   => [
                    'attr'        => [
                        'class' => 'form-control'
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => $this->_translator->trans('password.validation'),
                        ]),
                        new Length([
                            'min'        => 6,
                            'minMessage' => 'Votre mot de passe doit comporter au moins 6 caractères',
                            // max length allowed by Symfony for security reasons
                            'max'        => 4096,
                        ]),
                    ],
                    'label'       => $this->_translator->trans('new.password'),
                ],
                'second_options'  => [
                    'attr'  => [
                        'class' => 'form-control'
                    ],
                    'label' => $this->_translator->trans('repeated.password'),
                ],
                'invalid_message' => 'Les champs du mot de passe doivent correspondre.',
                'mapped'          => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
