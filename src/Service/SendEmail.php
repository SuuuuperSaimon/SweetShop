<?php


namespace App\Service;


use App\Entity\User;

class SendEmail
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var \Twig_Environment
     */
    private $enviroment;

    /**
     * SendEmail constructor.
     *
     * @param \Swift_Mailer $mailer
     *
     * @param \Twig_Environment $environment
     */
    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $environment)
    {
        $this->mailer = $mailer;
        $this->enviroment = $environment;
    }

    /**
     * @param User $user
     *
     * @return int
     *
     * @throws \Twig\Error\LoaderError
     *
     * @throws \Twig\Error\RuntimeError
     *
     * @throws \Twig\Error\SyntaxError
     */
    public function sendEmail(User $user) {
        $message = (new \Swift_Message('Hello'))
            ->setFrom('send@example.com')
            ->setTo($user->getEmail())
            ->setBody(
                $this->enviroment->render('forgottenPassword/email.html.twig', [
                        'user' => $user
                    ])
            );

        return $this->mailer->send($message);
    }
}