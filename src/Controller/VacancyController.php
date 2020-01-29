<?php

namespace App\Controller;

use App\Entity\JobReview;
use App\Entity\Vacancy;
use App\Form\JobReviewType;
use App\Form\VacancyType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VacancyController extends AbstractController
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /**
     * Vacancycontroller constructor
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/vacancy", name="vacancy")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $vacancy = $this->getDoctrine()
            ->getRepository(Vacancy::class)
            ->findAll();

        $jobReview = new JobReview();
        $form = $this->createForm(JobReviewType::class, $jobReview);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $this->entityManager->persist($jobReview);
            $this->entityManager->flush();
            $this->addFlash('success', 'Ваш отзыв отправле и будет обработан администраторами сайта');

            return $this->redirectToRoute('vacancy');
        }

        return $this->render('vacancy/index.html.twig', [
            'title'   => 'Вакансии',
            'vacancy' => $vacancy,
            'form'    => $form->createView()
        ]);
    }

    /**
     * @Route("/vacancy/show/{id}", name="vacancy_show")
     *
     * @param Vacancy $vacancy
     *
     * @return Response
     */
    public function show(Vacancy $vacancy)
    {
        return $this->render('vacancy/show.html.twig', [
            'title'   => 'Вакансия',
            'vacancy' => $vacancy,
        ]);
    }

    /**
     * @Route("/vacancy/edit/{id}", name="vacancy_edit")
     *
     * @param Request $request
     *
     * @param Vacancy $vacancy
     *
     * @return Response
     */
    public function edit(Request $request, Vacancy $vacancy) {
        $form = $this->createForm(VacancyType::class, $vacancy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($vacancy);
            $this->entityManager->flush();
            $this->addFlash('success', 'selected vacancy has been updated');

            return $this->redirectToRoute('vacancy');
        }

        return $this->render('vacancy/edit.html.twig', [
                'vacancy' => $vacancy,
                'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/vacancy/create", name="vacancy_create")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $vacancy = new Vacancy();
        $form = $this->createForm(VacancyType::class, $vacancy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //dd($vacancy);
            $this->entityManager->persist($vacancy);
            $this->entityManager->flush();
            $this->addFlash('success', 'new vacancy has been created');

            return $this->redirectToRoute('vacancy');
        }

        return $this->render('vacancy/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/vacancy/delete/{id}", name="vacancy_delete")
     *
     * @param Vacancy $vacancy
     *
     * @return Response
     */
    public function delete(Vacancy $vacancy)
    {
        if (!$vacancy) {
            throw $this->createNotFoundException(
                'No jobs found'
            );
        }

        $this->entityManager->remove($vacancy);
        $this->entityManager->flush();
        $this->addFlash('success', 'selected vacancy has been deleted');

        return $this->redirectToRoute('vacancy');
    }
}
