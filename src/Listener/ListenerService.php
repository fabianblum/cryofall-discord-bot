<?php

declare(strict_types=1);

namespace App\Listener;

use App\Actions\ActionService;
use App\Trait\AutoloadFiles;
use Discord\Discord;

class ListenerService
{
    use AutoloadFiles;

    private ActionService $actionService;

    public function __construct(ActionService $actionService)
    {
        $this->actionService = $actionService;
    }

    public function process(Discord $discord): void
    {
        echo "\nGet all listeners...";
        foreach ($this->getClassesImplementingInterface(AbstractListener::class) as $listenerFqn) {
            /** @var ListenerInterface $listener */
            $listener = new $listenerFqn($this->actionService);

            echo "\nAdd Listener (" . $listener->getEvent() . ")...";
            $discord->on($listener->getEvent(), $listener->listen());
        }
    }
}