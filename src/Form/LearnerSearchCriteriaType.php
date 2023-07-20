<?php

namespace App\Form;

use App\DTO\LearnerSearchCriteria;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LearnerSearchCriteriaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $criteria = $options['empty_data'];
        $builder
            ->add('size', NumberType::class, [
                'required' => false,
                'empty_data' => $criteria->size,
                'label'=>'Taille du groupe'

            ])->add('genre', CheckboxType::class, [
                'required' => false,
                'empty_data' => $criteria->genre,
                'label'=>'genre',
                'attr' => [
                    'class' => 'checkboxbutton',
                ],'label_attr' => ['class' => 'checkboxlabel']
                

            ])
            ->add('age', CheckboxType::class, [
                'required' => false,
                'empty_data' => $criteria->age,
                'label'=>'age',
                'attr' => [
                    'class' => 'checkboxbutton',
                ],'label_attr' => ['class' => 'checkboxlabel']
            ])
            ->add('skill', CheckboxType::class, [
                'required' => false,
                'empty_data' => $criteria->skill,
                'label'=>'compétence',
                'attr' => [
                    'class' => 'checkboxbutton',
                ],'label_attr' => ['class' => 'checkboxlabel']
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Créer',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'method' => 'GET',
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
