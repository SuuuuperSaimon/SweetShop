<?php


namespace App\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\AdminType;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AwardAdmin extends AbstractAdmin
{
//    /**
//     * @param RouteCollection $collection
//     */
//    public function configureRoutes(RouteCollection $collection)
//    {
//        $collection->add('add', $this->getRouterIdParameter().'/new');
//    }

    public function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper->add('award_name', TextType::class)
                   ->add('award_description', TextareaType::class)
                   ->add('award_image', TextType::class);
    }
    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('award_name', TextType::class)
                   ->add('award_description', TextareaType::class)
                   ->add('award_image', TextType::class);
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('award_name')
               ->add('award_description')
               ->add('award_image');
    }

    protected function configureListFields(ListMapper $list)
    {
        $list->add('award_name')
             ->add('award_description', null, [
                 'editable' => true,
             ])
             ->add('award_image')
             ->add('_action', null, [
                 'actions' => [
                     'show' => [],
                     'edit' => [],
                     'delete' => [],
                 ]
             ]);
    }

    public function prePersist($page)
    {
        $this->manageEmbeddedImageAdmins($page);
    }

    public function preUpdate($page)
    {
        $this->manageEmbeddedImageAdmins($page);
    }

    private function manageEmbeddedImageAdmins($page)
    {
//        foreach ($this->getFormFieldDescriptions() as $fieldName => $fieldDescription) {
//
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
//                        // update the Image to trigger file management
//                        $image->refreshUpdated();
//                    } elseif (!$image->getFile() && !$image->getFilename()) {
//                        // prevent Sf/Sonata trying to create and persist an empty Image
//                        $page->$setter(null);
//                    }
//                }
//            }
//        }
    }
}