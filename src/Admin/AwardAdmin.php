<?php

namespace App\Admin;

use App\Service\FileUploader;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AwardAdmin extends AbstractAdmin
{
    protected $fileUploader;

    public function __construct($code, $class, $baseControllerName, FileUploader $fileUploader)
    {
        parent::__construct($code, $class, $baseControllerName);
        $this->fileUploader = $fileUploader;
    }

    /**
     * @param ShowMapper $showMapper
     */
    public function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('award_name')
            ->add('award_description')
            ->add('award_image');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('award_name', TextType::class)
            ->add('award_description', TextareaType::class)
            ->add('file', FileType::class, [
                'required'   => false
            ]);
    }

    /**
     * @param DatagridMapper $filter
     */
    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('award_name')
            ->add('award_description')
            ->add('award_image');
    }

    /**
     * @param ListMapper $list
     */
    protected function configureListFields(ListMapper $list)
    {
        $list
          ->add('award_name')
          ->add('award_description', null, [
             'editable' => true
          ])
          ->add('award_image')
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
            $fileName = $this->fileUploader->upload($object->getFile(), "/awards");
            $object->setAwardImage($fileName);
        }
    }

    public function preUpdate($object)
    {
        if ($this->fileUploader->removeFile($object->getAwardImage(), '/awards')) {
            if ($object->getFile() instanceof UploadedFile) {
                $fileName = $this->fileUploader->upload($object->getFile(), "/awards");
                $object->setAwardImage($fileName);
            }
        }
    }

    public function preRemove($object)
    {
        $fileName = $object->getAwardImage();
        $this->fileUploader->removeFile($fileName, '/awards');
    }

    private function manageEmbeddedImageAdmins($page)
    {
//        foreach ($this->getFormFieldDescriptions() as $fieldName => $fieldDescription) {
//            if ($fieldDescription->getType() === 'sonata_type_admin' &&
//                ($associationMapping = $fieldDescription->getAssociationMapping()) &&
//                $associationMapping['targetEntity'] === 'App\Entity\Image'
//            ) {
//                $getter = 'get'.$fieldName;
//                $setter = 'set'.$fieldName;
//
//                /** @var Image $image */
//                $image = $page->$getter();
//
//                if ($image) {
//                    if ($image->getFile()) {
//                        $image->refreshUpdated();
//                    } elseif (!$image->getFile() && !$image->getFilename()) {
//                        $page->$setter(null);
//                    }
//                }
//            }
//        }
        if ($page->getFile()) {
            $page->lifecycleFileUpload();
            $page->refreshUpdated();
        }
    }
}