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
                'attr' => ['class' => 'form-control'],
            ])
            ->add('coursename', TextType::class, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('title', TextType::class, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('instructorname', TextType::class, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('callnumber', TextType::class, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('building', TextType::class, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('room', TextType::class, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('days', TextType::class, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('area', TextType::class, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('may', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'required' => false,
            ])
            ->add('summerterm', TextType::class, [
                'attr' => ['class' => 'form-control'],
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
