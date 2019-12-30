<?php

namespace App\Controller;

use App\Entity\Feedback;
use App\Form\FeedbackType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactsController extends AbstractController
{
    /**@var EntityManagerInterface*/
    private $entityManager;

    /**
     * ContactsController constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/contacts", name="contacts")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $message = new Feedback();
        $form = $this->createForm(FeedbackType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($message);
            $this->entityManager->flush();
            $this->addFlash('success', 'Ваше сообщение отправлено администратору. В ближайшее время с Вами свяжутся');

            return $this->redirectToRoute('contacts');
        }

        return $this->render('contacts/index.html.twig', [
            'title' => 'Контакты',
            'form' => $form->createView()
        ]);
    }
}
