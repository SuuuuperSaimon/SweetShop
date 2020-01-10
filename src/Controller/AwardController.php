<?php

namespace App\Controller;

use App\Entity\Award;
use App\Form\AwardType;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AwardController extends AbstractController
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /**
     * AwardController constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/award", name="award")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $awards = $this
            ->getDoctrine()
            ->getRepository(Award::class)
            ->findAll();

        return $this->render('award/index.html.twig', [
            'awards' => $awards,
            'title'  => 'Награды',
        ]);
    }

    /**
     * @Route("/award/new", name="award_new")
     *
     * @param Request $request
     *
     * @param FileUploader $fileUploader
     *
     * @return Response
     */
    public function new(Request $request, FileUploader $fileUploader)
    {
        $award = new Award();
        $form = $this->createForm(AwardType::class, $award);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//            dd($award);
//            $file = $form['award_image']->getData();
            $fileName = $fileUploader->upload($award->getFile(), "/awards");
            $award->setAwardImage($fileName);

            $this->entityManager->persist($award);
            $this->entityManager->flush();
            $this->addFlash('success', 'new award has been created');

            return $this->redirectToRoute('award');
        }

        return $this->render('award/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/award/{id}", name="award_show")
     *
     * @param Award $award
     *
     * @return Response
     */
    public function show(Award $award): Response
    {
        return $this->render('award/show.html.twig', [
            'award' => $award,
            'title' => 'Награды'
        ]);
    }

    /**
     * @Route("/award/edit/{id}", name="award_edit")
     *
     * @param Request $request
     *
     * @param Award $award
     *
     * @param FileUploader $fileUploader
     *
     * @return Response
     */
    public function edit(Request $request, Award $award, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(AwardType::class, $award);
        $form->handleRequest($request);

        //dd($form->getData());
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['award_image']->getData();
            if ($file) {
                $fileName = $fileUploader->upload($file, '/awards');
                $award->setAwardImage($fileName);
            }
            $this->entityManager->flush();
            $this->addFlash('success', 'selected award has been updated');

            return $this->redirectToRoute('award');
        }

        return $this->render('award/edit.html.twig', [
            'award' => $award,
            'form'  => $form->createView(),
        ]);
    }

    /**
     * @Route("/award/delete/{id}", name="award_delete")
     *
     * @param Award $award
     *
     * @return Response
     */
    public function delete(Award $award): Response
    {
        if (!$award) {
            throw $this->createNotFoundException(
                'No awards found'
            );
        }

        $this->entityManager->remove($award);
        $this->entityManager->flush();
        $this->addFlash('success', 'selected award has been deleted');

        return $this->redirectToRoute('award');
    }
}
