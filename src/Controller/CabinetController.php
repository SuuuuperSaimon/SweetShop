<?php


namespace App\Controller;


use App\Entity\User;
use App\Form\UserType;
use App\Service\PasswordHash;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CabinetController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var PasswordHash
     */
    private $hash;

    /**
     * CabinetController constructor.
     *
     * @param EntityManagerInterface $em
     *
     * @param PasswordHash $hash
     */
    public function __construct(EntityManagerInterface $em, PasswordHash $hash)
    {
        $this->em   = $em;
        $this->hash = $hash;
    }

    /**
     * @param Request $request
     *
     * @param User $user
     *
     * @return Response
     */
    public function edit(Request $request, User $user)
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

        }
    }
}