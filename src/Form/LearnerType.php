<?php

namespace App\Form;

use App\Entity\Learner;
use App\Entity\Prom;
use App\Entity\Skill;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LearnerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', TextType::class, [
                'required' => true,
                'label' => 'Nom',
            ])
            ->add('firstname', TextType::class, [
                'required' => true,
                'label' => 'Prénom',
            ])
            ->add('age', NumberType::class, [
                'required' => true
            ])
            ->add('gender', ChoiceType::class, array(
                'choices' => array(
                    'Homme' => 'm',
                    'Femme' => 'f',
                ),
                'label' => 'genre',
                'expanded' => true,
                'required' => true
            ))
            ->add('skills', EntityType::class, [
                'class' => Skill::class,
                'multiple' => true,
                'choice_label' => 'label',
                'required' => false,
                'label' => 'Compétences',
            ])
            ->add('prom',  EntityType::class, array(
                'class' => Prom::class,
                'choice_label' => 'label',
                'required' => true,
                'label' => 'Promotion',
            ))
            ->add('submit', SubmitType::class, [
                'label' => 'Creer',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Learner::class,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}
