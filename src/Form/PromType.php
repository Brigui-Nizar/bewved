<?php

namespace App\Form;

use App\Entity\Prom;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PromType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label',TextType::class,[
                'required' => true,
            ])  
            ->add('submit', SubmitType::class, [
                'label' => 'Creer',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Prom::class,
        ]);
    }
    public function getBlockPrefix(): string
    {
        return '';
    }
}
