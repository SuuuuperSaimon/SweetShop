<?php


namespace App\Controller;



use App\Entity\User;
use App\Form\EMailConfirmType;
use App\Service\SendEmail;
use App\Service\TokenGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForgottenPasswordController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var TokenGenerator
     */
    private $generator;
    /**
     * @var SendEmail
     */
    private $mailer;

    /**
     * ForgottenPasswordController constructor.
     *
     * @param EntityManagerInterface $em
     *
     * @param TokenGenerator $generator
     *
     * @param SendEmail $mailer
     */
    public function __construct(EntityManagerInterface $em, TokenGenerator $generator, SendEmail $mailer)
    {
        $this->em = $em;
        $this->generator = $generator;
        $this->mailer = $mailer;
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
        /**
         * @var User $user
         */
        $user = $this->getUser();
        $form = $this->createForm(EMailConfirmType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();
            $user = $this->em->getRepository(User::class)->findOneBy(['email' => $email]);

            if (!$user->getResetTokenAt()) {
                $ressetingToken = $this->generator->generateToken();
                $reset_token_at = new \DateTime();

                $user->setRessetingToken($ressetingToken);
                $user->setResetTokenAt($reset_token_at);

                $this->em->flush();
            }

            if ($user->getResetTokenAt()) {
                $this->mailer->sendEmail($user);
                return $this->render('forgottenPassword/confirmationSending.html.twig');
            }
        }

        return $this->render('forgottenPassword/forgottenPassword.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/change-password/{token}", name="change_password")
     */
    private function changePassword($token)
    {
        return $this->render('forgottenPassword/change_password.html.twig', [
            'token' => $token
        ]);
    }
}
