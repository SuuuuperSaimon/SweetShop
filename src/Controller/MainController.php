<?php


namespace App\Controller;



use App\Entity\News;
use App\Service\SerchService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    private $service;

    /**
     * MainController constructor
     *
     * @param SerchService $service
     */
    public function __construct(SerchService $service)
    {
        $this->service = $service;
    }

    /**
     * @Route("/", name="home_index")
     */
    public function show()
    {
        $limitNews = $this->service->searchFore();

        return $this->render('sweetShop/main.html.twig', [
            'title' => 'Welcome',
            'news' => $limitNews
        ]);
    }

    /**
     * @Route("/aboutus", name="about_us")
     *
     */
    public function adoutUs() {

        return $this->render('aboutus.html.twig', [
            'title' => 'О нас',
        ]);
    }
}