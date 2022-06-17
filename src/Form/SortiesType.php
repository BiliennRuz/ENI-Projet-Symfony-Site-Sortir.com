<?php

namespace App\Form;

use App\Entity\Sorties;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Component\Form\Extension\Core\Type\TimeType ;

class SortiesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, ["label" => "Nom de la sortie"])
            ->add('datedebut', DateTimeType::class, ["label" => "Date et heure de la sortie"], array ('attr' => array('class' => 'metro-input cell-9')))
            ->add('datecloture', DateType::class ,["label" => "Date limite d'inscription"], array ('attr' => array('class' => 'metro-input cell-9')))
            ->add('duree',TimeType::class,["label" => "Durée"])

            ->add('nbinscriptionsmax')
            ->add('descriptioninfos', TextareaType::class, [
                "label" => "Descriptions et infos",
                "attr" => array('class' => 'metro-input cell-9'),
                ])
            ->add('urlphoto')
            ->add('etatsNoEtat')
            ->add('organisateur')
            ->add('lieuxNoLieu')
            ->add('participantsNoParticipant')
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sorties::class,
        ]);
    }
}
