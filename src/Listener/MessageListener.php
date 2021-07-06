<?php

declare(strict_types=1);

namespace App\Listener;

use Discord\Discord;
use Discord\Parts\Channel\Message;

class MessageListener extends AbstractListener
{
    protected string $event = 'message';

    public function listen(): callable
    {
        return function (Message $message, Discord $discord) {
            return $this->actionService->process($message, $discord);
        };
    }
}