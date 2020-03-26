<?php

namespace App\Form;

use App\Entity\Course;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('term', TextType::class, [
                'attr' => ['class' => 'cmp-form-field__input'],
            ])
            ->add('coursename', TextType::class, [
                'attr' => ['class' => 'cmp-form-field__input'],
            ])
            ->add('title', TextType::class, [
                'attr' => ['class' => 'cmp-form-field__input'],
            ])
            ->add('instructorname', TextType::class, [
                'attr' => ['class' => 'cmp-form-field__input'],
            ])
            ->add('callnumber', TextType::class, [
                'attr' => ['class' => 'cmp-form-field__input'],
            ])
            ->add('building', TextType::class, [
                'attr' => ['class' => 'cmp-form-field__input'],
            ])
            ->add('room', TextType::class, [
                'attr' => ['class' => 'cmp-form-field__input'],
            ])
            ->add('days', TextType::class, [
                'attr' => ['class' => 'cmp-form-field__input'],
            ])
            ->add('time', TextType::class, [
                'attr' => ['class' => 'cmp-form-field__input'],
            ])
            ->add('area', TextType::class, [
                'attr' => ['class' => 'cmp-form-field__input'],
            ])
            ->add('may', TextType::class, [
                'attr' => ['class' => 'cmp-form-field__input'],
                'required' => false,
            ])
            ->add('summerterm', TextType::class, [
                'attr' => ['class' => 'cmp-form-field__input'],
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Course::class,
        ]);
    }
}
