<?php

namespace App\Form;

use App\Entity\DemandeConge;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DemandeCongeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date_debut')
            ->add('lieu_jouissance')
            ->add('type_conge')
            ->add('motif')
            ->add('nom_interim')
            ->add('num_demande')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DemandeConge::class,
        ]);
    }
}
