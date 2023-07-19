<?php

namespace App\Form;

use App\Entity\Learner;
use App\Entity\Skill;
use App\Entity\SkillGroup;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SkillType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label', TextType::class, [
                'required' => true,
                'label' => 'Nom',
            ])
            ->add('skillGroup', EntityType::class, [
                'class' => SkillGroup::class,
                'choice_label' => 'code',
                'required' => true,
                'label' => 'Compétences liée',/* 
                'choice_value' => 'id' */


            ])

            ->add('submit', SubmitType::class, [
                'label' => 'Creer',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Skill::class,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}
