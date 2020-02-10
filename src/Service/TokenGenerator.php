<?php


namespace App\Service;


use App\Entity\User;

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
        if ($date) {
            if ((date_add($date, date_interval_create_from_date_string('1 days'))) > (new \DateTime())) {
                return false;
            }
        }

        return true;
    }

    public function removeToken(User $user)
    {
        $user->setRessetingToken(null);
        $user->setResetTokenAt(null);
        $this->service->addObject($user);

        return $user;
    }
}