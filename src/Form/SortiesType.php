<?php

namespace App\Form;

use App\Entity\Lieux;
use App\Entity\Participants;
use App\Entity\Sorties;
use App\Entity\Villes;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



class SortiesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, array('attr' => array('label' => "Nom de la sortie:", 'class' => 'metro-input cell-10', 'placeholder' => 'nom')))
            ->add('datedebut', DateType::class, array('attr' => array('class' => 'metro-input cell-10')))
            ->add('duree', IntegerType::class, array('attr' => array('class' => 'metro-input cell-10', 'placeholder' => 'durée')))
            ->add('datecloture', DateType::class, array('attr' => array('label' => 'Date de clôture', 'class' => 'metro-input cell-10')))
            ->add('nbinscriptionsmax', IntegerType::class, array('attr' => array('class' => 'metro-input cell-10')))
            ->add('descriptioninfos', TextAreaType::class, array('attr' => array('class' => 'metro-input cell-10', 'placeholder' => "Description")))
            ->add('lieuxNoLieu', EntityType::class, [
                'class' => Lieux::class,
                'choice_label' => 'nomLieu',
                'label' => "Lieu",
                'attr' => array('class' => 'metro-input cell-10')
            ])

            // ->add('rue', EntityType::class, [
            //     'class' => Lieux::class,
            //     'choice_label' => 'Lieux',
            //     'label' => "Rue",
            //     'attr' => array('class' => 'metro-input cell-10')
            // ])
            

            // ->add('participantsNoParticipant')
            // ->add('sitesNoSite')
            // ->add('sitesNoSite', EntityType::class,[

            // 'class' => Participants::class,
            // 'choice_label' => 'nomSite',
            // 'label' => "Ville organisatrice",
            // 'attr' => array('class' => 'metro-input cell-10')
            // ])

            // -> add ('rue')
            // , TextType::class,[
            //     'class' => Lieux::class,
            //     'choice_label' => 'nomLieu',
            //     'label' => "Lieu",
            //     'attr' => array('class' => 'metro-input cell-10')
            //     ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sorties::class,
        ]);
    }
}
