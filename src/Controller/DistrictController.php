<?php

namespace App\Controller;

use App\Entity\District;
use App\Form\DistrictType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DistrictController extends AbstractController
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /**
     * DistrictController constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/district", name="district")
     *
     * @return Response
     */
    public function index()
    {   $district = $this->getDoctrine()
                         ->getRepository(District::class)
                         ->findAll();

        return $this->render('district/index.html.twig', [
            'title'    => 'Магазины по районам',
            'district' => $district,
        ]);
    }

    /**
     * @Route("/district/show/{id}", name="district_show")
     *
     * @param District $district
     *
     * @return Response
     */
    public function show(District $district)
    {
        return $this->render('district/show.html.twig', [
            'title'    => 'Район',
            'district' => $district,
        ]);
    }

    /**
     * @Route("/district/edit/{id}", name="district_edit")
     *
     * @param Request $request
     *
     * @param District $district
     *
     * @return Response
     */
    public function edit(Request $request, District $district)
    {
        $form = $this->createForm(DistrictType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($district);
            $this->entityManager->flush();
            $this->addFlash('success', 'selected district has been updated');

            return $this->redirectToRoute('district');
        }

        return $this->render('district/edit.html.twig', [
            'district' => $district,
            'form'     => $form->createView(),
        ]);
    }

    /**
     * @Route("/district/new", name="district_new")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function new(Request $request)
    {
        $district = new District();
        $form = $this->createForm(DistrictType::class, $district);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //dd($district);
            $this->entityManager->persist($district);
            $this->entityManager->flush();
            $this->addFlash('success', 'new district has been created');

            return $this->redirectToRoute('district');
        }

        return $this->render('district/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/district/delete/{id}", name="district_delete")
     *
     * @param District $district
     *
     * @return Response
     */
    public function delete(District $district)
    {
        if (!$district) {
            throw $this->createNotFoundException(
                'No districtes found'
            );
        }

        $this->entityManager->remove($district);
        $this->entityManager->flush();
        $this->addFlash('success', 'selected district has been deleted');

        return $this->redirectToRoute('district');
    }
}
