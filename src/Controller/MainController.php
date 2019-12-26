<?php


namespace App\Controller;



use App\Entity\News;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /**
     * MainController constructor
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="home_index")
     */
    public function show()
    {
        $limitNews = $this->entityManager
            ->getRepository(News::class)
            ->findBy(
                [],
                ['id' => 'DESC'],
                4
            );
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