<?php
namespace App\Form;

use App\Entity\Sorties;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Participants;
use App\Entity\Lieux;


class CancelSortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class,[
                'label' => "Nom de la sortie: "
            ])
            ->add('datedebut', DateTimeType::class, array('widget' => 'single_text', 'attr' => array('class' => 'metro-input cell-7'),'label' => "Date de la sortie: "))
            ->add('organisateur', EntityType::class, [
                'class' => Participants::class,
                'choice_label' => 'sitesNosite',
                'label' => "Ville organisatrice :",
                'attr' => array('class' => 'metro-input cell-6')
                ])
            ->add('lieuxNoLieu', EntityType::class, [
                'class' => Lieux::class,
                'choice_label' => 'nomLieu',
                'label' => "Lieu :",
                'attr' => array('class' => 'metro-input cell-6')
                ])
            ->add('descriptioninfos',TextareaType::class, [
                'label' => 'Motif'
            ])
            ->add('submit', SubmitType::class,[
                'label' =>'.',
                'attr' => [
                    'class' => 'button primary mif-floppy-disk rounded text-primary'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sorties::class,
        ]);
    }
}