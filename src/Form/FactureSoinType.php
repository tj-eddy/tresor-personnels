<?php

namespace App\Form;

use App\Entity\FactureSoin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FactureSoinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('num_fact', TextType::class, [
                'attr'     => [
                    'class' => 'form-control'
                ],
                'required' => true,
                'label'=>'Numéro de la facture'
            ])
            ->add('date_fact', TextType::class, [
                'attr'     => [
                    'class' => 'form-control date-picker',
                ],
                'required' => true,
                'label'=>'Date de facture'
            ])
            ->add('montant', IntegerType::class, [
                'attr'     => [
                    'class' => 'form-control'
                ],
                'required' => true,
                'label'=>'Montant'
            ])
            ->add('pharmacie', TextType::class, [
                'attr'     => [
                    'class' => 'form-control'
                ],
                'required' => true,
                'label'=>'Nom du pharmacie'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FactureSoin::class,
        ]);
    }
}
