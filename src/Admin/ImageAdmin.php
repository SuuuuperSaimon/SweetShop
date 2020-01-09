<?php


namespace App\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ImageAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('file', FileType::class, [
                'required' => false,
            ])
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('filename')
               ->add('updated');
    }

    protected function configureListFields(ListMapper $list)
    {
        $list->add('filename')
             ->add('updated');
    }



    public function prePersist($image)
    {
        if ($image->getFile()) {
            $image->lifecycleFileUpload();
            $image->refreshUpdated();
        }
        //$this->manageFileUpload($image);
    }

    public function preUpdate($image)
    {
        $this->manageFileUpload($image);
    }

    private function manageFileUpload($image)
    {
        if ($image->getFile()) {
            $image->lifecycleFileUpload();
            $image->refreshUpdated();
        }
    }
}