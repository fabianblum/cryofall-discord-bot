<?php

declare(strict_types=1);

namespace App\Service;

use App\Listener\ListenerService;
use Discord\Discord;
use Discord\Exceptions\IntentException;
use Discord\Parts\User\Activity;
use React\EventLoop\Factory;

class Bot
{
    private Discord $discord;
    private ListenerService $listenerService;

    /**
     * @throws IntentException
     */
    public function __construct(ListenerService $listenerService, string $token)
    {
        $loop = Factory::create();

        $this->discord = new Discord(
            [
                'token' => $token,
                'loop' => $loop,
            ]
        );
        $this->listenerService = $listenerService;
    }


    public function run(): void
    {
        $this->listenerService->process($this->discord);

        $activity = $this->discord->factory(
            Activity::class,
            [
                'name' => ' Cryofall',
                'type' => Activity::TYPE_PLAYING
            ]
        );

        $discord = $this->discord;
        $this->discord->getLoop()->addPeriodicTimer(
            60,
            function () use ($discord, $activity) {
                $discord->updatePresence($activity);
            }
        );


        $discord->run();
    }
}