<?php

namespace App\Form;

use App\Entity\JobReview;
use App\Entity\Vacancy;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JobReviewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('fathersName')
            ->add('vacancy', EntityType::class, [
                'class' => Vacancy::class,
                'choice_label' => 'vacancyName'
            ])
            ->add('email')
            ->add('comment')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => JobReview::class,
        ]);
    }
}
