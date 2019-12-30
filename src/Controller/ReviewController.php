<?php

namespace App\Controller;

use App\Entity\Review;
use App\Form\ReviewType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReviewController extends AbstractController
{
    /**
     * @var EntityManagerInterface $entityManager
     */
    private $enittyManager;

    /**
     * ReviewController constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->enittyManager = $entityManager;
    }

    /**
     * @Route("/review", name="review")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $reviews = $this->getDoctrine()
            ->getRepository(Review::class)
            ->findBy([
                'is_checked' => true,
            ]);

        $review = new Review();
        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->enittyManager->persist($review);
            $this->enittyManager->flush();
            $this->addFlash('success', 'Ваш отзыв был отправлен и будет проверен администратором');

            return $this->redirectToRoute('review');
        }

        return $this->render('review/index.html.twig', [
            'reviews' => $reviews,
            'title'=> 'Отзывы о нас',
            'form' => $form->createView(),
        ]);
    }
}
