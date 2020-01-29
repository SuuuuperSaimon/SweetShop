<?php

namespace App\Form;

use App\Entity\Review;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReviewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Ваше имя'
            ])
            ->add('fathersName', TextType::class, [
                'label' => 'Ваше отчество'
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Ваша фамилия'
            ])
            ->add('email', TextType::class, [
                'label' => 'Ваш E-Mail'
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'Ваш отзыв'
            ])
            ->add('is_checked', HiddenType::class, [
                'empty_data' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Review::class,
        ]);
    }
}
