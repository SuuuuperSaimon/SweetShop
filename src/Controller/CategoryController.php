<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /**
     * Category constructor
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /** @Route("/category", name="category") */
    public function index()
    {
        $categories = $this->getDoctrine()
                         ->getRepository(Category::class)
                         ->findAll();

        return $this->render('category/index.html.twig', [
            'title' => 'Категории',
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/category/show/{id}", name="category_show")
     *
     * @param Category $category
     *
     * @return Response
     */
    public function show(Category $category)
    {
        return $this->render('category/show.html.twig',[
            'category' => $category,
            'title' => 'Категория',
        ]);
    }

    /**
     * @Route("/category/new", name="category_new")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function new(Request $request) {
        $category = new Category();
        $form     = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        //dd($form->getData());
        if ($form->isSubmitted() && $form->isValid()) {
            //dd($category);
            $this->entityManager->persist($category);
            $this->entityManager->flush();
            $this->addFlash('success', 'new category has been created');

            return $this->redirectToRoute('category');
        }

        return $this->render('category/create.html.twig', [
             'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/category/edit/{id}", name="category_edit")
     *
     * @param Category $category
     *
     * @param Request $request
     *
     * @return Response
     */
    public function edit(Category $category, Request $request) {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($category);
            $this->entityManager->flush();
            $this->addFlash('success', 'selected category has been updated');

            return $this->redirectToRoute('category');
        }

        return $this->render('category/edit.html.twig', [
            'category' => $category,
            'form'     => $form->createView(),
        ]);
    }

    /**
     * @Route("/category/delete/{id}", name="category_delete")
     *
     * @param Category $category
     *
     * @return Response
     */
    public function delete(Category $category)
    {
        if (!$category) {
            throw $this->createNotFoundException(
                'No category found'
            );
        }

        $this->entityManager->remove($category);
        $this->entityManager->flush();
        $this->addFlash('success', 'selected category has been deleted');

        return $this->redirectToRoute('category');
    }
}
