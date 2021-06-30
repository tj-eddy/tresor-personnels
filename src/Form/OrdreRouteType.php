<?php

namespace App\Form;

use App\Entity\OrdreRoute;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrdreRouteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('num_or', TextType::class, [
                'label' => "Numéro",
                'attr'  => [
                    'class' => 'form-control'
                ]
            ])
            ->add('dateOr', TextType::class, [
                'label'    => "Date OR",
                'attr'     => [
                    'class' => 'form-control'
                ],
            ])
            ->add('dateDebutMission', TextType::class, [
                'label' => "Date du début",
                'attr'  => [
                    'class' => 'form-control',
                ]
            ])
            ->add('dateFinMission', TextType::class, [
                'label' => "Date du fin",
                'attr'  => [
                    'class' => 'form-control'
                ]
            ])
            ->add('objet_mission', TextType::class, [
                'label' => "Objet",
                'attr'  => [
                    'class' => 'form-control'
                ]
            ])
            ->add('scan_or', FileType::class, [
                'label'    => "Scan d'ordre de route",
                'attr'     => [
                    'class' => 'form-control'
                ],
                'required' => false
            ])
            ->add('indice', IntegerType::class, [
                'label'    => "Indice sur OR",
                'attr'     => [
                    'class' => 'form-control'
                ],
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OrdreRoute::class,
        ]);
    }
}
