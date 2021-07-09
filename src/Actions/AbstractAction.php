<?php

declare(strict_types=1);

namespace App\Actions;

use App\Configuration\BotConfiguration;
use Discord\Discord;
use Discord\Parts\Channel\Message;

abstract class AbstractAction implements ActionInterface
{
    private BotConfiguration $botConfig;

    public function __construct()
    {
        $this->botConfig = new BotConfiguration();
    }

    protected function getBotConfig(): BotConfiguration
    {
        return $this->botConfig;
    }

    public function getRegex(): string
    {
        return $this->regex;
    }

    abstract public function process(Message $message, Discord $discord, array $matches): void;

    protected string $regex;
}