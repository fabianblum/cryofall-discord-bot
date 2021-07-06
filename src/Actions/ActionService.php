<?php

declare(strict_types=1);

namespace App\Actions;

use App\Trait\AutoloadFiles;
use Discord\Discord;
use Discord\Parts\Channel\Message;

class ActionService
{
    use AutoloadFiles;

    public function process(Message $message, Discord $discord): ?string
    {
        echo "\nGet all classes...";
        foreach ($this->getClassesImplementingInterface(AbstractAction::class) as $actionFqn) {
            /** @var ActionInterface $action */
            $action = new $actionFqn();

            echo "\nCheck ".$action->getRegex()."...";
            if (preg_match($action->getRegex(), strtolower($message->content))) {
                echo " match. Run action";
                $action->process($message, $discord);
            }
        }

        return null;
    }
}