<?php

namespace App\MessageHandler;

use App\Message\Contactez;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class ContactezHandler implements MessageHandlerInterface
{
    public function __invoke(Contactez $message)
    {
        // do something with your message
    }
}
