<?php


namespace App\Service;


use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PasswordHash
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * PasswordHash constructor.
     *
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param $object
     *
     * @param $password
     *
     * @return mixed
     */
    public function HashPassword($object, $password)
    {
        return $object->setPassword($this->passwordEncoder->encodePassword(
            $object,
            $password
        ));
    }
}