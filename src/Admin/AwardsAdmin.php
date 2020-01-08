<?php


namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AwardAdmin extends AbstractAdmin
{
    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('award_name', TextType::class)
                   ->add('award_description', TextareaType::class)
                   ->add('award_image', FileType::class, [
                            'mapped'   => false,
                            'required' => false
                        ]);
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('award_name')
               ->add('award_description')
               ->add('award_image');
    }

    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('award_name')
             ->addIdentifier('award_description')
             ->addIdentifier('award_image');
    }
}