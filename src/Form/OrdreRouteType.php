<?php

namespace App\Form;

use App\Entity\OrdreRoute;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrdreRouteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('num_or')
            ->add('date_or')
            ->add('objet_mission')
            ->add('date_debut_mission')
            ->add('date_fin_mission')
            ->add('scan_or')
            ->add('status')
            ->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OrdreRoute::class,
        ]);
    }
}
