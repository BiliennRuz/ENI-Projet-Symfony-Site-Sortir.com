<?php

namespace App\Form;

use App\Entity\Participants;
use App\Entity\Sites;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ParticipantsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo',TextType::class, array ('attr' => array('class' => 'metro-input cell-9','placeholder'=>"pseudo")))       
            ->add('prenom',TextType::class, array ('attr' => array('class' => 'metro-input cell-9','placeholder'=>"Prénom")))
            ->add('nom',TextType::class, array ('attr' => array('class' => 'metro-input cell-9','placeholder'=>"Nom")))
            ->add('telephone',TextType::class, array ('attr' => array('class' => 'metro-input cell-9','placeholder'=>"Téléphone")))
            ->add('email',TextType::class, array ('attr' => array('class' => 'metro-input cell-9','placeholder'=>"Email")))
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class, 'options' => ['attr' => ['class' => 'password-field metro-input cell-9','placeholder'=>"mdp"]],
                'first_options'  => ['label' => ' '] , 
                'second_options' => ['label' => ' ']        
        ])
        ->add('photo', FileType::class, [
            'attr' => ['type' => 'file',
                        'data-role' => 'file',
                        ],

            'label' => 'Photo Image file (jpg, jpeg, png, gif)',
            'mapped' => false,
            'required' => false,
            'constraints' => [
                new File([
                    'maxSize' => '4096k',
                    'mimeTypes' => [
                        'image/jpeg',
                        'image/jpg',
                        'image/png',
                        'image/gif',
                        // jpg, jpeg, png, gif
                    ],
                    'mimeTypesMessage' => 'Please upload a valid vignette Media file',
                ])
            ],
        ])
            ->add('sitesNoSite', EntityType::class, [

                'class' =>  Sites::class,
                'choice_label' => 'nomSite',
                'label' => "Villes de rattachement",
                'attr' => array('class' => 'metro-input cell-9')

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participants::class,
        ]);
    }
}
