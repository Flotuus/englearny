<?php

namespace App\Form;

use App\Entity\Liste;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Mot;
use App\Entity\Entreprise;
use App\Entity\Theme;

class ModifListeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('libelle',TextType::class)
        ->add('mots',EntityType::class,array("class"=>"App\Entity\Mot","choice_label"=>"libelle"))
        ->add('entreprise',EntityType::class,array("class"=>"App\Entity\Entreprise","choice_label"=>"libelle"))
        ->add('theme',EntityType::class, array("class"=>"App\Entity\Theme","choice_label"=>"libelle"))
        ->add('ajouter',SubmitType::class)
    ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Liste::class,
        ]);
    }
}
