<?php

declare(strict_types=1);

namespace App\Actions;

use Discord\Discord;
use Discord\Parts\Channel\Message;

interface ActionInterface
{
    public function getRegex(): string;

    public function process(Message $message, Discord $discord): void;
}