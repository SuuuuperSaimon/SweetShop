<?php


namespace App\Service;


use App\Entity\News;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class SerchService
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * SerchService constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface  $em)
    {
        $this->em = $em;
    }

    public function searchFore() {
        return $this
            ->em
            ->getRepository(News::class)
            ->findPart();
    }

    public function findNews($element) {
        return $this
            ->em
            ->getRepository(News::class)
            ->searchNews($element);
    }
}