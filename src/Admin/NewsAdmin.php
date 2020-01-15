<?php

namespace App\Admin;

use App\Service\FileUploader;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class NewsAdmin extends AbstractAdmin
{
    protected $fileUploader;

    public function __construct($code, $class, $baseControllerName, FileUploader $fileUploader)
    {
        parent::__construct($code, $class, $baseControllerName);
        $this->fileUploader = $fileUploader;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('newsName', TextType::class)
            ->add('newsAnnotation', TextType::class)
            ->add('newsText', TextareaType::class)
            ->add('newsDate', DateType::class)
            ->add('file', FileType::class, [
                'required' => false
            ]);
    }

    /**
     * @param ShowMapper $showMapper
     */
    public function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('newsName')
            ->add('newsAnnotation')
            ->add('newsText')
            ->add('newsDate')
            ->add('newsImage');
    }

    /**
     * @param DatagridMapper $filterMapper
     */
    protected function configureDatagridFilters(DatagridMapper $filterMapper)
    {
        $filterMapper
            ->add('newsName')
            ->add('newsAnnotation')
            ->add('newsText')
            ->add('newsDate')
            ->add('newsImage');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('newsName')
            ->add('newsAnnotation')
            ->add('newsText')
            ->add('newsDate')
            ->add('newsImage')
            ->add('_action', null, [
                'actions' => [
                    'show'   => [],
                    'edit'   => [],
                    'delete' => []
                ]
            ]);
    }

    public function prePersist($object)
    {
        if ($object->getFile() instanceof UploadedFile) {
            $fileName = $this->fileUploader->upload($object->getFile(), '/news');
            $object->setNewsImage($fileName);
        }
    }

    public function preUpdate($object)
    {
        if ($this->fileUploader->removeFile($object->getNewsImage(), '/news')) {
            if ($object->getFile() instanceof UploadedFile) {
                $fileName = $this->fileUploader->upload($object->getFile(), "/news");
                $object->setNewsImage($fileName);
            }
        }
    }

    public function preRemove($object)
    {
        $fileName = $object->getNewsImage();
        $this->fileUploader->removeFile($fileName, '/news');
    }
}