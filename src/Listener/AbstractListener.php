<?php

declare(strict_types=1);

namespace App\Listener;

use App\Actions\ActionService;

abstract class AbstractListener implements ListenerInterface
{
    protected string $event;
    protected ActionService $actionService;

    abstract public function listen(): callable;

    public function __construct(ActionService $actionService)
    {
        $this->actionService = $actionService;
    }

    public function getEvent(): string
    {
        return $this->event;
    }
}