<?php

namespace App\Form;

use App\Entity\Attribution;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AttributionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom_tache', ChoiceType::class, [
                'attr'    => [
                    'class'    => 'form-control select-2',
                    'multiple' => 'multiple',
                ],
                'choices' => $this->getTaskName()
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Attribution::class,
        ]);
    }

    /**
     * @return string[]
     */
    protected function getTaskName()
    {
        return [
            'Visa facture achat DREN'              => 'Visa facture achat DREN',
            'Visa facture achat CISCO'             => 'Visa facture achat CISCO',
            'Visa facture achat DRAP'              => 'Visa facture achat DRAP',
            'Visa facture achat TOURISME'          => 'Visa facture achat TOURISME',
            'Visa facture achat TRIBUNAL'          => 'Visa facture achat TRIBUNAL',
            'Visa facture achat DRAEP'             => 'Visa facture achat DRAEP',
            'Visa facture achat PREFECURE'         => 'Visa facture achat PREFECURE',
            'Visa facture achat FINANCE'           => 'Visa facture achat FINANCE',
            'Visa facture achat GREFTP'            => 'Visa facture achat GREFTP',
            'Visa ordre de route DREN'             => 'Visa ordre de route DREN',
            'Visa ordre de route CISCO'            => 'Visa ordre de route CISCO',
            'Visa ordre de route DRAP'             => 'Visa ordre de route DRAP',
            'Visa ordre de route TOURISME'         => 'Visa ordre de route TOURISME',
            'Visa ordre de route TRIBUNAL'         => 'Visa ordre de route TRIBUNAL',
            'Visa ordre de route DRAEP'            => 'Visa ordre de route DRAEP',
            'Visa ordre de route PREFECURE'        => 'Visa ordre de route PREFECURE',
            'Visa ordre de route FINANCE'          => 'Visa ordre de route FINANCE',
            'Visa facture JIRAMA'                  => 'Visa facture JIRAMA',
            'Visa Frais de soins'                  => 'Visa Frais de soins',
            'Responsable Pension'                  => 'Responsable Pension',
            'Caisier'                              => 'Caisier',
            'Envoi de Transfert'                   => 'Envoi de Transfert',
            'Couverture transfert Poste comptable' => 'Couverture transfert Poste comptable',
            'Supérieure'                           => 'Supérieure',
            'Couverture transport Perceptions'     => 'Couverture transport Perceptions',
            'Principales'                          => 'Principales',
            'Couverture transfert RAF'             => 'Couverture transfert RAF',
            'Responsable Compte d\'attente'        => 'Responsable Compte d\'attente',
            'Responsable Compte de dépôt'          => 'Responsable Compte de dépôt',
            'Responsable Accueil'                  => 'Responsable Accueil',
            'Trésorier Général'                    => 'Trésorier Général',
            'Responsable Commune'                  => 'Responsable Commune',
            'Responsable Région'                   => 'Responsable Région',
        ];
    }
}

