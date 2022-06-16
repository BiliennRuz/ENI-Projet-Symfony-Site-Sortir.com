<?php

namespace App\Form;

use App\Entity\Sites;
use App\Service\SearchDataSorties;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchFormSorties extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sites', EntityType::class, [
                'label' => 'Site : ',
                'required' => false,
                'class' => Sites::class,
                // uses the Sites.nomSite property as the visible option string
                'choice_label' => 'nomSite',
                'expanded' => true,
                'multiple' => true
            ])

            ->add('nom', TextType::class, [
                'label' => 'Le nom contient : ',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Recherche'
                ]
            ])
            
            ->add('dateDebut', DateType::class, [
                'label' => 'Entre ',
                'required' => false,
                'widget' => 'choice',
            ])
            ->add('dateFin', DateType::class, [
                'label' => 'Et ',
                'required' => false,
                'widget' => 'choice',
            ])

            ->add('isOrganisateur', CheckboxType::class, [
                'label' => 'Sorties dont je suis l\'organisateur\/trice',
                'required' => false,
            ])
            ->add('isInscrit', CheckboxType::class, [
                'label' => 'Sorties auquelles je suis inscrit\/e',
                'required' => false,
            ])
            ->add('isnotInscrit', CheckboxType::class, [
                'label' => 'Sorties auquelles je ne suis pas inscrit\/e',
                'required' => false,
            ])
            ->add('isSortiePassee', CheckboxType::class, [
                'label' => 'Sortie passées',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchDataSorties::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }

}