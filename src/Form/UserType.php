<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    private $_translator;
    private $security;

    /**
     * PpApprovisionementDirecteType constructor.
     */
    public function __construct(Security $security)
    {
        $this->security    = $security;
        $this->_translator = new Translator(\Locale::getDefault());
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $roles = array_values($this->security->getUser()->getRoles());

        $builder
            ->add('username', TextType::class, [
                'label' => 'Nom',
                'attr'  => [
                    'class'       => 'form-control',
                    'placeholder' => "Nom complet ... "
                ],

            ])
            ->add('email', EmailType::class, [
                "label" => "Adresse email",
                'attr'  => [
                    'class'       => 'form-control',
                    "placeholder" => "Addresse email ..."
                ]
            ])
            ->add('cin', TextType::class, [
                'label' => 'Numéro CIN',
                'attr'  => [
                    'class'       => 'form-control',
                    "placeholder" => "Carte d'Identité Nationale ..."
                ]
            ])
            ->add('dateNaissance', TextType::class, [
                'label' => 'Date de naissance',
                'attr'  => [
                    'class'       => 'form-control date-picker',
                    "placeholder" => "Date de naissance ...",
                ]
            ])
            ->add('dateStartService', TextType::class, [
                'label' => 'Date prise de service',
                'attr'  => [
                    'class'       => 'form-control date-picker',
                    "placeholder" => "Date prise de service ...",
                ]
            ])
            ->add('matricule', TextType::class, [
                'label'    => "Matricule",
                'required' => false,
                'attr'     => [
                    'class'       => 'form-control d-none',
                    'readonly'    => true,
                    "placeholder" => "Numéro matricule ... "
                ]
            ])
            ->add('childNumber', IntegerType::class, [
                'attr'     => [
                    'class'       => 'form-control d-none',
                    "placeholder" => "Nombre d'enfant ... "
                ],
                'required' => false,
                'label'    => "Nombre d'enfant"
            ])
            ->add('profil', FileType::class, [
                'label'    => "Photo de profil",
                'attr'     => [
                    'class' => 'form-control'
                ],
                'mapped'   => false,
                'required' => false,
                //                'constraints' => [
                //                    new File([
                //                        'maxSize' => '1024k',
                //                        'mimeTypes' => [
                //                            'application/jpg',
                //                            'application/png',
                //                        ],
                //                        'mimeTypesMessage' => 'Veuillez choisir une image valide',
                //                    ])
                //                ],
            ]);
        if (!in_array('ROLE_SUPERADMIN', $roles)) {
            $builder
                ->add('password', RepeatedType::class, [
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
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
