<?php

namespace App\Controller;

use App\Entity\News;
use App\Form\NewsType;
use App\Repository\NewsRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class NewsController extends AbstractController
{
    /** @var EntityManagerInterface*/
    private $entityManager;

    /**
     * NewsController constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/news", name="news_index")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request)
    {
        $news = $this->getDoctrine()
            ->getRepository(News::class)
            ->findAll();

        $pagination = $paginator->paginate(
            $news,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('news/news.html.twig', [
            'pagination' => $pagination,
            'title' => 'Новости компании',
        ]);
    }

    /**
     * @Route("/news/new", name="news_new")
     * @param Request $request
     * @param FileUploader $fileUploader
     * @return Response
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        $news = new News();
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //dd();
            $file = $form['newsImage']->getData();
            $fileName = $fileUploader->upload($file, '/news');
            $news->setNewsImage($fileName);

            $this->entityManager->persist($news);
            $this->entityManager->flush();
            $this->addFlash('success', 'new news has been created');

            return $this->redirectToRoute('news_index');
        }

        return $this->render('news/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/news/{id}", name="news_show")
     * @param News $news
     * @return Response
     */
    public function show(News $news): Response
    {
        return $this->render('news/show.html.twig', [
            'news' => $news,
        ]);
    }

    /**
     * @Route("/news/edit/{id}", name="news_edit")
     * @param Request $request
     * @param News $news
     * @param FileUploader $fileUploader
     * @return Response
     */
    public function edit(Request $request, News $news, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        //dd($form->getData());
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['newsImage']->getData();
            if ($file) {
                $fileName = $fileUploader->upload($file, "/news");
                $news->setNewsImage($fileName);
            }
            $this->entityManager->flush();
            $this->addFlash('success', 'selected news has been updated');

            return $this->redirectToRoute('news_index');
        }

        return $this->render('news/edit.html.twig', [
            'news' => $news,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/news/delete/{id}", name="news_delete")
     * @param News $news
     * @return Response
     */
    public function delete(News $news): Response
    {
        if (!$news) {
            throw $this->createNotFoundException(
                'No news found'
            );
        }

        $this->entityManager->remove($news);
        $this->entityManager->flush();
        $this->addFlash('success', 'selected news has been deleted');

        return $this->redirectToRoute('news_index');
    }
}
