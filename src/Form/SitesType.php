<?php

namespace App\Form;

use App\Entity\Sites;
use App\Data\SearchData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SitesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomSite', TextType::class, 
            [
                "label" => "Nom du site",
                'required' => false,
                'attr' => [
                    'placeholder' => 'Rechercher dans le nom'
                ]
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sites::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

}
