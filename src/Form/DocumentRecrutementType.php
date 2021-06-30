<?php

namespace App\Form;

use App\Entity\DocumentRecrutement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
                    'class'       => 'form-control',
                    'placeholder' => 'Numéro de document'
                ],
                'label' => "Numéro de document"
            ])
            ->add('typeDoc', ChoiceType::class, [
                'attr'    => [
                    'class' => 'form-control select-2',
                ],
                'choices' => [
                    'Contrat de travail' => 'Contrat de travail',
                    'Arrêté'             => 'Arrêté',
                ],
                'label'   => "Type de document"
            ])
            ->add('date_doc', TextType::class, [
                'attr'  => [
                    'class'       => 'form-control date-picker',
                    'readonly'    => true,
                    'placeholder' => 'Date document'
                ],
                'label' => "Date"
            ])
            ->add('corps', ChoiceType::class, [
                'attr'    => [
                    'class'       => 'form-control select-2',
                    'placeholder' => 'Corps'
                ],
                'choices' => [
                    "Sous opérateur"                     => "Sous opérateur",
                    "Opérateur"                          => "Opérateur",
                    "Encadreurs"                         => "Encadreurs",
                    "Technicien Supérieur"               => "Technicien Supérieur",
                    "Réalisateurs Adjoints"              => "Réalisateurs Adjoints",
                    "Réalisateurs"                       => "Réalisateurs",
                    "Concepteur"                         => "Concepteur",
                    "Contrôleur du Trésor"               => "Contrôleur du Trésor",
                    "Percepteur Principaux des Finances" => "Percepteur Principaux des Finances",
                    "Inspecteur du Trésor"               => "Inspecteur du Trésor",
                    "Comptable du Trésor"                => "Comptable du Trésor"
                ],
                'label'   => "Corps"
            ])
            ->add('indice', IntegerType::class, [
                'attr'  => [
                    'class'       => 'form-control',
                    "maxlength"   => 3,
                    "minlength"   => 3,
                    'placeholder' => 'Indice'
                ],
                'label' => "Indice"
            ])
            ->add('scanDoc', FileType::class, [
                'mapped'   => false,
                'required' => false,
                'attr'     => [
                    'class' => 'form-control',
                ],
                'label'    => "Scan de document"
            ])
            ->add('categorie', ChoiceType::class, [
                'attr'    => [
                    'class'       => 'form-control select-2',
                    'placeholder' => 'Catégorie'
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
            ->add('grade', ChoiceType::class, [
                'attr'    => [
                    'class'       => 'form-control select-2',
                    'placeholder' => 'Grade'
                ],
                'choices' => [
                    "Stagiaire"                     => "Stagiaire",
                    "2ème Classe 1er Échelon"       => "2ème Classe 1er Échelon",
                    "2ème Classe 2è Échelon"        => "2ème Classe 2è Échelon",
                    "2ème Classe 3è Échelon"        => "2ème Classe 3è Échelon",
                    "1ère Classe 1er Échelon"       => "1ère Classe 1er Échelon",
                    "1ère Classe 2è Échelon"        => "1ère Classe 2è Échelon",
                    "1ère Classe 3è Échelon"        => "1ère Classe 3è Échelon",
                    "Classe Principale 1er Échelon" => "Classe Principale 1er Échelon",
                    "Classe Principale 2è Échelon"  => "Classe Principale 2è Échelon",
                    "Classe Principale 3è Échelon"  => "Classe Principale 3è Échelon",
                    "Classe Exceptionnelle"         => "Classe Exceptionnelle"
                ],
                'label'   => "Grade"
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DocumentRecrutement::class,
        ]);
    }
}
