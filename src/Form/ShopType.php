<?php

namespace App\Form;

use App\Entity\District;
use App\Entity\Shop;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShopType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('shop_address', TextType::class, [
                'label'        => 'Введите адрес магазина'
            ])
            ->add('is_brand', ChoiceType::class, [
                'label'        => 'Это фирменный магазин?',
                'placeholder'  => 'Выберете',
                'choices'      => [
                    'Да'  => true,
                    'Нет' => false
                ]
            ])
            ->add('district', EntityType::class, [
                'class'        => District::class,
                'label'        => 'Выберете район',
                'placeholder'  => 'Районы',
                'choice_label' => 'district_name'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Shop::class,
        ]);
    }
}
