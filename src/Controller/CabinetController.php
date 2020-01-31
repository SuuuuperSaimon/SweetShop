<?php


namespace App\Controller;


use App\Entity\User;
use App\Form\CabinetType;
use App\Form\ResetPasswordType;
use App\Form\UserType;
use App\Service\FileUploader;
use App\Service\PasswordHash;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * CabinetController constructor.
     *
     * @param EntityManagerInterface $em
     *
     * @param PasswordHash $hash
     *
     * @param FileUploader $fileUploader
     *
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(EntityManagerInterface $em, PasswordHash $hash, FileUploader $fileUploader, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->em              = $em;
        $this->hash            = $hash;
        $this->fileUploader    = $fileUploader;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/cabinet", name="private_cabinet")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function editProfile(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(CabinetType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($user->getFile()) {
                $this->fileUploader->removeFile($user->getUserImage(), "/users");
                $filename = $this->fileUploader->upload($user->getFile(), "/users" );
                $user->setUserImage($filename);
            }

            $this->em->flush();

            return $this->redirectToRoute('private_cabinet');
        }

        return $this->render('cabinet/cabinet.html.twig', [
            'form'  => $form->createView(),
            'user'  => $user,
            'title' => 'Личный кабинет'
        ]);
    }

    /**
     * @Route("/cabinet/reset-password", name="reset_password")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function resetPassword(Request $request)
    {

        $user = $this->getUser();
        $form = $this->createForm(ResetPasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->passwordEncoder->isPasswordValid($user, $form->get('oldPassword')->getData())) {
                $user->setPassword($this->passwordEncoder->encodePassword($user, $form->get('plainPassword')->getData()));

                $this->em->flush();
            } else {
                throw $this->createNotFoundException(
                    'Wrong password'
                );
            }

            return $this->redirectToRoute('private_cabinet');
        }

        return $this->render('resetPassword/resetPassword.html.twig', [
            'form'  => $form->createView(),
            'title' => 'Reset password'
        ]);
    }
}