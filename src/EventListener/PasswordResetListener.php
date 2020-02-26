<?php


namespace App\EventListener;


use App\Event\PasswordResetedEvent;

class PasswordResetListener
{

    public function onPasswordReset(PasswordResetedEvent $event)
    {
        dd('works!');
    }
}