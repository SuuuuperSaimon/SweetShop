<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('productName', TextType::class)
            ->add('productWieght', NumberType::class)
            ->add('productDesc',TextareaType::class)
            ->add('is_new', ChoiceType::class, [
                'label'   => 'Это новинка?',
                'choices' => [
                    'Yes' => true,
                    'No'  => false
                ],
            ])
            ->add('category', EntityType::class, [
                'class'        => Category::class,
                'label'        => 'Выберете категорию',
                'placeholder'  => 'Категория',
                'choice_label' => 'categoryName',
            ])
            ->add('file',FileType::class, [
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
