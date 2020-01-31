<?php


namespace App\Controller;



use App\Entity\User;
use App\Form\CheckEmaillType;
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
     * ForgottenPasswordController constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route ("/forgot", name="forgot_password")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function sendEmail(Request $request)
    {
        /** @var User $user */
        $user = $this->getUser();
        $form = $this->createForm(CheckEmaillType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dd($form->get('email')->getData());
            $email = $form->get('email')->getData();
            dump($email);die;
        }

        return $this->render('forgottenPassword/forgottenPassword.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
