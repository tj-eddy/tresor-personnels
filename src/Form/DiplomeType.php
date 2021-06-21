<?php

namespace App\Form;

use App\Entity\Diplome;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DiplomeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numero', TextType::class, [
                'attr'  => [
                    'class' => 'form-control'
                ],
                'label' => "Numéro du diplôme"
            ])
            ->add('annee', TextType::class, [
                'attr'  => [
                    'class' => 'form-control date-picker-diplome',
                ],
                'label' => "Année d'obtention"
            ])
            ->add('nom_diplome', TextType::class, [
                'attr'  => [
                    'class' => 'form-control'
                ],
                'label' => 'Nom du diplôme'
            ])
            ->add('scan', FileType::class, [
                'mapped'   => false,
                'required' => false,
                'attr'     => [
                    'class' => 'form-control'
                ],
                'label'    => "Scan du diplôme",
            ])
            ->add('etablissement', TextType::class, [
                'attr'  => [
                    'class' => 'form-control'
                ],
                'label' => "Etablissement"
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Diplome::class,
        ]);
    }
}
