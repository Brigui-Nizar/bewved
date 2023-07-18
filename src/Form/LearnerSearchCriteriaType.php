<?php

namespace App\Form;

use App\DTO\LearnerSearchCriteria;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LearnerSearchCriteriaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $criteria = $options['empty_data'];
        $builder
            ->add('genre', CheckboxType::class, [
                'required' => false,
                'empty_data' => $criteria->genre,
            ])
            ->add('age', CheckboxType::class, [
                'required' => false,
                'empty_data' => $criteria->age,
            ])
            ->add('skill', CheckboxType::class, [
                'required' => false,
                'empty_data' => $criteria->skill,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LearnerSearchCriteria::class,
            'data' => new LearnerSearchCriteria(),
            'empty_data' => new LearnerSearchCriteria(),
        ]);
    }


    public function getBlockPrefix(): string
    {
        return '';
    }
}
