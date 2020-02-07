<?php


namespace App\Service;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class BaseService
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * BaseService constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param $object
     *
     * @return ObjectRepository
     */
    public function getRepository($object) {
        return $this->em->getRepository($object);
    }

    public function addObject($object)
    {
        $this->em->persist($object);
        $this->em->flush();

        return $object;
    }

    public function removeObject($object)
    {
        $this->em->remove($object);
        $this->em->flush();

        return $object;
    }
}