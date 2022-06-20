<?php

namespace App\Form;

use App\Entity\Lieux;
use App\Entity\Participants;
use App\Entity\Sorties;
use App\Entity\Villes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Component\Form\Extension\Core\Type\TimeType ;
use Symfony\Component\Validator\Constraints\File;


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

            // Upload de photo
              ->add('urlphoto', FileType::class, [
                'label' => 'Image (fichier image)',
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/jpeg',//
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Veuillez sélectionner un fichier image valide',
                    ])
                ],
            ])
            // ...
              
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sorties::class,
        ]);
    }
}
