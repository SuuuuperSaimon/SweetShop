<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('categoryName', TextType::class, [
                'label' => 'Название категории',
            ])
            ->add('parent', EntityType::class, [
                'class'        => Category::class,
                'choice_label' => 'categoryName',
                'placeholder'  => '',
                'required'     => false,
                'label'        => 'Дочерняя категория',
            ])
            ->add('children', EntityType::class, [
                'class'        => Category::class,
                'choice_label' => 'categoryName',
                'placeholder'  => '',
                'required'     => false,
                'label'        => 'Родительская категория',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
