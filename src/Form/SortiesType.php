<?php

namespace App\Form;

use App\Entity\Participants;
use App\Entity\Sorties;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class SortiesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, array('attr' => array('label' => 'nom', 'class' => 'metro-input cell-9', 'placeholder' => 'nom')))
            ->add('datedebut', DateType::class, array('attr' => array('label' => 'Date début','class' => 'metro-input cell-9')))
            // ->add('duree', DateType::class, ["label" => "Durée"])
            // ->add('duree',TimeType::class , array ('attr' => array('label'=>'durée','class' => 'metro-input cell-9')))
            ->add('datecloture', DateType::class, array('attr' => array('class' => 'metro-input cell-9')))
            ->add('nbinscriptionsmax', IntegerType::class, array('attr' => array('class' => 'metro-input cell-9')))
            ->add('descriptioninfos', TextType::class, array('attr' => array('class' => 'metro-input cell-9', 'placeholder' => "Description")))
            // ->add('etatsNoEtat', EntityType::class,[
            //     'class' =>  Sorties::class,
            //     'choice_label' => 'etatsNoEtat',
            //     'label' => "Etat de la sortie",
            //     'attr' => array('class' => 'metro-input cell-9')
            //     ])
                
                ->add('organisateur')
                ->add('lieuxNoLieu')
                ->add('participantsNoParticipant')
                ->add('urlphoto');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sorties::class,
        ]);
    }
}