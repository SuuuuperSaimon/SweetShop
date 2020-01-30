<?php


namespace App\Controller;


use App\Form\UserType;
use App\Service\FileUploader;
use App\Service\PasswordHash;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CabinetController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var PasswordHash
     */
    private $hash;
    /**
     * @var FileUploader
     */
    private $fileUploader;

    /**
     * CabinetController constructor.
     *
     * @param EntityManagerInterface $em
     *
     * @param PasswordHash $hash
     *
     * @param FileUploader $fileUploader
     */
    public function __construct(EntityManagerInterface $em, PasswordHash $hash, FileUploader $fileUploader)
    {
        $this->em           = $em;
        $this->hash         = $hash;
        $this->fileUploader = $fileUploader;
    }

    /**
     * @Route("/cabinet", name="private_cabinet")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function edit(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->hash->HashPassword($user, $form->get('plainPassword')->getData());

            if ($user->getFile()) {
                $this->fileUploader->removeFile($user->getUserImage(), "/users");
                $filename = $this->fileUploader->upload($user->getFile(), "/users" );
                $user->setUserImage($filename);
            }

            $this->em->flush();

           // return $this->redirectToRoute('private_cabinet');
        }

        return $this->render('cabinet/cabinet.html.twig', [
            'form'  => $form->createView(),
            'user'  => $user,
            'title' => 'Личный кабинет'
        ]);
    }
}