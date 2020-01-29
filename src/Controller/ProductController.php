<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
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

    /**
     * @Route("/product/show/{id}", name="product_show")
     *
     * @param Product $product
     *
     * @return Response
     */
    public function show(Product $product)
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/product/edit/{id}", name="product_edit")
     *
     * @param Request $request
     *
     * @param Product $product
     *
     * @param FileUploader $fileUploader
     *
     * @return Response
     */
    public function edit(Request $request, Product $product, FileUploader $fileUploader)
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$file = $form['productImage']->getData();
            if ($product->getFile()) {
                $fileName = $fileUploader->upload($product->getFile(), "/news");
                $product->setProductImage($fileName);
            }

            $this->entityManager->flush();
            $this->addFlash('success', 'selected product has been updated');

            return $this->redirectToRoute('category');
        }

        return $this->render('product/edit.html.twig', [
            'product' => $product,
            'form'    => $form->createView(),
        ]);
    }

    /**
     * @Route("/product/create", name="product_create")
     *
     * @param Request $request
     *
     * @param FileUploader $fileUploader
     *
     * @return Response
     */
    public function new(Request $request, FileUploader $fileUploader)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$file = $form['productImage']->getData();
            $fileName = $fileUploader->upload($product->getFile(), "/products");
            $product->setProductImage($fileName);

            $this->entityManager->persist($product);
            $this->entityManager->flush();
            $this->addFlash('success', 'new product has been created');

            return $this->redirectToRoute('category');
        }

        return $this->render('product/create.html.twig', [
            'form'    => $form->createView(),
            'product' => $product,
        ]);
    }

    /**
     * @Route("/product/delete/{id}", name="product_delete")
     *
     * @param Product $product
     *
     * @return Response
     */
    public function delete(Product $product)
    {
        if (!$product) {
            throw $this->createNotFoundException(
                'No products found'
            );
        }

        $this->entityManager->remove($product);
        $this->entityManager->flush();
        $this->addFlash('success', 'selected product has been deleted');

        return $this->redirectToRoute('product');
    }
}
