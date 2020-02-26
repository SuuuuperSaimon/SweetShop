<?php


namespace App\Event;


use Symfony\Contracts\EventDispatcher\Event;

class PasswordResetedEvent extends Event
{
    public const PASSWORD_RESET = 'password.reset';
}