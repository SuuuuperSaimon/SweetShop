<?php


namespace App\Admin;


use App\Entity\Country;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\BaseService;
use App\Service\FileUploader;
use App\Service\PasswordHash;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminAdmin extends AbstractAdmin
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * @var PasswordHash
     */
    private $hash;

    /**
     * @var FileUploader
     */
    private $fileUploader;
    /**
     * @var BaseService
     */
    private $service;
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * AdminAdmin constructor.
     *
     * @param $code
     *
     * @param $class
     *
     * @param $baseControllerName
     *
     * @param PasswordHash $hash
     *
     * @param FileUploader $fileUploader
     *
     * @param UserRepository $repository
     * @param BaseService $service
     */
    public function __construct($code, $class, $baseControllerName, PasswordHash $hash, FileUploader $fileUploader, UserRepository $repository , BaseService $service)
    {
        parent::__construct($code, $class, $baseControllerName);

        $this->hash = $hash;
        $this->fileUploader = $fileUploader;
        $this->service = $service;
        $this->repository = $repository;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('username', TextType::class)
            ->add('email', EmailType::class)
            ->add('firstname', TextType::class)
            ->add('lastname', TextType::class)
            ->add('country', EntityType::class, [
                'class'        => Country::class,
                'label'        => 'Choose your country',
                'placeholder'  => 'Country',
                'choice_label' => 'countryName',
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type'     => PasswordType::class,
                'mapped'   => false,
                'required' => false,
                'first_options' => [
                    'label' => 'Password'
                ],
                'second_options' => [
                    'label' => 'Repeat Password'
                ]
            ])
            ->add('file', FileType::class, [
                'required'   => false
            ]);
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('username')
            ->add('email')
            ->add('firstname')
            ->add('lastname')
            ->add('country.countryName')
            ->add('userImage');
    }

    /**
     * @param DatagridMapper $filterMapper
     */
    protected function configureDatagridFilters(DatagridMapper $filterMapper)
    {
        $filterMapper
            ->add('id')
            ->add('username')
            ->add('email')
            ->add('firstname')
            ->add('lastname')
            ->add('country.countryName')
            ->add('userImage');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('username')
            ->add('email')
            ->add('firstname')
            ->add('lastname')
            ->add('country.countryName', TextType::class, [
                'label' => 'Country'
            ])
            ->add('userImage')
            ->add('_action', null, [
                'actions' => [
                    'show'   => [],
                    'edit'   => [],
                    'delete' => []
                ]
            ]);
    }

    /**
     * @param object $object
     */
    public function prePersist($object)
    {
        $password = $this->getForm()->get('plainPassword')->getData();
        $this->hash->HashPassword($object, $password);

        $object->addAdminRole('ROLE_ADMIN');

        if ($object->getFile() instanceof UploadedFile) {
            $fileName = $this->fileUploader->upload($object->getFile(), "/users");
            $object->setUserImage($fileName);
        }
    }

    /**
     * @param object $object
     */
    public function preUpdate($object)
    {
        if ($this->getForm()->get('plainPassword')->getData()) {
            $password = $this->getForm()->get('plainPassword')->getData();
            $this->hash->HashPassword($object, $password);
        }

        if ($object->getFile() instanceof UploadedFile) {
            $fileName = $object->getUserImage();
            $this->fileUploader->removeFile($fileName, '/users');
            $imageFileName = $this->fileUploader->upload($object->getFile() , '/users');
            $object->setUserImage($imageFileName);
        }
    }

    public function preRemove($object)
    {
        $fileName = $object->getUserImage();
        $this->fileUploader->removeFile($fileName, '/users');
    }

    public function createQuery($context = 'list')
    {
        $repository = $this
            ->service
            ->getRepository(User::class)
        ;

        $query = new ProxyQuery($repository->adminSearch());

        foreach($this->extensions as $extension) {
            $extension->configureQuery($this, $query, $context);
        }

        return $query;
    }
}