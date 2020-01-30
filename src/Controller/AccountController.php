<?php


namespace App\Controller;


class AccountController
{
    public function accountinfo()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');
    }

    public function resetPassword()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
    }

}