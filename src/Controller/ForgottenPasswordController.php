<?php


namespace App\Controller;

use App\Entity\User;
use App\Event\PasswordResetedEvent;
use App\EventListener\PasswordResetListener;
use App\Form\ChangePasswordType;
use App\Form\EMailConfirmType;
use App\Service\PasswordHash;
use App\Service\SendEmail;
use App\Service\TokenGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForgottenPasswordController extends AbstractController
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var TokenGenerator */
    private $generator;

    /** @var SendEmail */
    private $mailer;

    /** @var PasswordHash */
    private $hash;
    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * ForgottenPasswordController constructor.
     *
     * @param EntityManagerInterface $em
     *
     * @param TokenGenerator $generator
     *
     * @param SendEmail $mailer
     *
     * @param PasswordHash $hash
     *
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(EntityManagerInterface $em, TokenGenerator $generator, SendEmail $mailer, PasswordHash $hash, EventDispatcherInterface $dispatcher)
    {
        $this->em = $em;
        $this->generator = $generator;
        $this->mailer = $mailer;
        $this->hash = $hash;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @Route ("/forgot-password", name="forgot_password")
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function forgotPassword(Request $request)
    {
        $this->dispatcher->dispatch(new PasswordResetedEvent(), PasswordResetedEvent::PASSWORD_RESET);

        /** @var User $user */
        $user = $this->getUser();
        $form = $this->createForm(EMailConfirmType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();
            $user = $this
                ->em
                ->getRepository(User::class)
                ->findOneBy(['email' => $email]);

            if (!$user) {

                return $this->render('forgottenPassword/email_input.html.twig', [
                   'invalid_email' => $email,
                   'form'          => $form->createView()
                ]);
            } else {
                if ($user->getResetTokenAt() === null || $this->generator->checkTokenLifetime($user->getResetTokenAt())) {
                    $this->generator->addToUserToken($user);
                    $this->mailer->sendEmail($user);

                    return $this->render('forgottenPassword/confirmationSending.html.twig');
                } else {

                    return $this->render('forgottenPassword/email_input.html.twig',[
                        'invalid_token' => $email,
                        'form'          => $form->createView()
                    ]);
                }
            }
        }

        return $this->render('forgottenPassword/forgottenPassword.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/change-password/{ressetingToken}", name="change_password")
     *
     * @param Request $request
     *
     * @param User $user
     *
     * @return RedirectResponse|Response
     */
    public function changePassword(Request $request, User $user)
    {
        $this->dispatcher->dispatch(new PasswordResetedEvent());

        dd(321);
        $form = $this->createForm(ChangePasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this
                ->hash
                ->hashPassword($user, $form->get('plainPassword')->getData());
            $this->generator->removeToken($user);
            $this->em->flush();
//            $this->dispatcher->addListener(PasswordResetedEvent::PASSWORD_RESET, [new PasswordResetListener(), 'onPasswordReset']);

            return $this->redirectToRoute('app_login');
        }

        return $this->render('forgottenPassword/change_password.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
