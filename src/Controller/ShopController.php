<?php

namespace App\Controller;

use App\Entity\Shop;
use App\Form\ShopType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractController
{
    /**@var EntityManagerInterface*/
    private $entityManager;

    /**
     * ShopController constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/stores", name="stores")
     */
    public function shops() {

        return $this->render('shop/shops.html.twig', [
             'title' => 'Магазины'
        ]);
    }
    /**
     * @Route("/brandshops", name="brandstores")
     * @param Request $request
     * @return Response
     */
    public function brandShops(Request $request)
    {
        $brandShops = $this->getDoctrine()
            ->getRepository(Shop::class)
            ->findBy([
               'is_brand' => true
            ]);

        return $this->render('shop/brand_shops.html.twig', [
            'title'      => 'Фирменные магазины',
            'brandShops' => $brandShops,
        ]);
    }

    /**
     * @Route("/stores/new", name="store_new")
     * @param Request $request
     * @return
     */
    public function new(Request $request)
    {
        $store = new Shop();
        $form = $this->createForm(ShopType::class, $store);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($store);
            $this->entityManager->flush();
            $this->addFlash('success', 'new shop has been created');

            return $this->redirectToRoute('stores');
        }

        return $this->render('shop/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/stores/store/{id}", name="store_show")
     * @param Shop $shop
     * @return Response
     */
    public function show(Shop $shop)
    {
        return $this->render('shop/show.html.twig', [
            'title' => 'Магазины',
            'shop'  => $shop,
        ]);
    }

    /**
     * @Route("/stores/edit/{id}", name="store_edit")
     * @param Request $request
     * @param Shop $shop
     * @return Response
     */
    public function edit(Request $request, Shop $shop)
    {
        $form = $this->createForm(ShopType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($shop);
            $this->entityManager->flush();
            $this->addFlash('success', 'selected store has been updated');

            return $this->redirectToRoute('stores');
        }

        return $this->render('shop/edit.html.twig', [
            'shop' => $shop,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/stores/delete/{id}", name="store_delete")
     * @param Shop $shop
     * @return Response
     */
    public function delete(Shop $shop)
    {
        if (!$shop) {
            throw $this->createNotFoundException(
                'No stores found'
            );
        }

        $this->entityManager->remove($shop);
        $this->entityManager->flush();
        $this->addFlash('success', 'selected store has been deleted');

        return $this->redirectToRoute('stores');
    }
}
