<?php


namespace App\Service;


class TokenGenerator
{
    /**
     * @var BaseService
     */
    private $service;

    /**
     * TokenGenerator constructor.
     *
     * @param BaseService $service
     */
    public function __construct(BaseService $service)
    {
        $this->service = $service;
    }

    /**
     * @return string
     *
     * @throws \Exception
     */
    public function generateToken()
    {
        return rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
    }

    /**
     * @param User $user
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function addToUserToken(User $user)
    {
        $user->setRessetingToken($this->generateToken());
        $user->setResetTokenAt(new \DateTime());

        return $this->service->addObject($user);
    }

    /**
     * @param $date
     *
     * @return bool
     *
     * @throws \Exception
     */
    public function checkTokenLifetime($date)
    {
        if (($date->add(new DateInterval('P1D'))) > (new \DateTime()) ) {
            return true;
        }

        return false;
    }

    public function removeToken(User $user)
    {
        $user->setRessetingToken(null);
        $user->setResetTokenAt(null);
        $this->service->addObject($user);

        return $user;
    }
}