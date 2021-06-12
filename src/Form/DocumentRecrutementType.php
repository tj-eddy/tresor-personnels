<?php

namespace App\Form;

use App\Entity\DocumentRecrutement;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocumentRecrutementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('num_doc', TextType::class, [
                'attr'  => [
                    'class'    => 'form-control',
                    'readonly' => true
                ],
                'label' => "Numero de document"
            ])
            ->add('type_doc', TextType::class, [
                'attr'  => [
                    'class' => 'form-control'
                ],
                'label' => "Type du document"
            ])
            ->add('date_doc', TextType::class, [
                'attr'  => [
                    'class'    => 'form-control',
                    'readonly' => true
                ],
                'label' => "Date"
            ])
            ->add('corps', TextType::class, [
                'attr'  => [
                    'class' => 'form-control'
                ],
                'label' => "Corps"
            ])
            ->add('indice', IntegerType::class, [
                'attr'  => [
                    'class' => 'form-control'
                ],
                'label' => "Indice"
            ])
            ->add('categorie', ChoiceType::class, [
                'attr'    => [
                    'class' => 'form-control select-2'
                ],
                'choices' => [
                    'Cat I'    => 'I',
                    'Cat II'   => 'II',
                    'Cat III'  => 'III',
                    'Cat IV'   => 'IV',
                    'Cat V'    => 'V',
                    'Cat VI'   => 'VI',
                    'Cat VII'  => 'VII',
                    'Cat VIII' => 'VIII',
                    'Cat XI'   => 'XI',
                ],
                'label'   => "Catégorie"
            ])
            ->add('grade', TextType::class, [
                'attr'  => [
                    'class' => 'form-control'
                ],
                'label' => "Grade"
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DocumentRecrutement::class,
        ]);
    }
}
