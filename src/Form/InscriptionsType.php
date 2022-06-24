<?php

namespace App\Form;

use App\Entity\Inscriptions;
use App\Entity\Participants;
use App\Entity\Sorties;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class InscriptionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateInscription', DateType::class , array ('attr' => array('class' => 'metro-input cell-9'))) 
            ->add('sortiesNoSortie', EntityType::class, [
                'class' =>  Sorties::class,
                'choice_label' => 'nom',
                'label' => "Choisir la sortie ",
                'attr' => array('class' => 'metro-input cell-9')

            ])
            ->add('participantsNoParticipant',EntityType::class , [
                'class' =>  Participants::class,
                'choice_label' => 'pseudo',
                'label' => "Participant",
                'attr' => array('class' => 'metro-input cell-9')
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Inscriptions::class,
        ]);
    }
}
