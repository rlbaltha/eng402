<?php

namespace App\Form;

use App\Entity\Term;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TermType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('term', TextType::class, [
                'attr' => ['class' => 'cmp-form-field__input'],
            ])
            ->add('termname', TextType::class, [
                'attr' => ['class' => 'cmp-form-field__input'],
            ])
            ->add('status', TextType::class, [
                'attr' => ['class' => 'cmp-form-field__input'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Term::class,
        ]);
    }
}
