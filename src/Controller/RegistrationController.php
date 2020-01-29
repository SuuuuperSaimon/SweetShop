<?php

namespace App\Controller;

use App\Form\UserType;
use App\Entity\User;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var FileUploader */
    private $fileUploader;

    /** @var UserPasswordEncoderInterface */
    private $passwordEncoder;

    /**
     * RegistrationController constructor.
     *
     * @param EntityManagerInterface $entityManager
     *
     * @param UserPasswordEncoderInterface $passwordEncoder
     *
     * @param FileUploader $fileUploader
     */
    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder, FileUploader $fileUploader)
    {
        $this->entityManager = $entityManager;
        $this->fileUploader = $fileUploader;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/register", name="user_registration")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function registerAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $password = $this->passwordEncoder->encodePassword($user, $form->get('plainPassword')->getData());
            $user->setPassword($password);

            if ($user->getFile()) {
                $filename = $this->fileUploader->upload($user->getFile(), "/users" );
                $user->setUserImage($filename);
            }

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return $this->redirectToRoute('home_index');
        }

        return $this->render('registration/register.html.twig', [
            'form'  => $form->createView(),
            'title' => 'Регистрация'
        ]);
    }
}
