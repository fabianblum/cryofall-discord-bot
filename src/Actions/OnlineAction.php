<?php

declare(strict_types=1);

namespace App\Actions;

use App\Api\ServerApi;
use CryoFallStatisticsApiClient\ApiException;
use Discord\Discord;
use Discord\Parts\Channel\Message;
use Exception;

class OnlineAction extends AbstractAction
{
    protected string $regex = '/^!online$/';

    /**
     * @throws ApiException
     * @throws Exception
     */
    public function process(Message $message, Discord $discord, array $matches): void
    {
        $api = new ServerApi($this->getBotConfig()->getServerGuid());

        $playersOnline = $api->getPlayersOnline();

        $message->reply(sprintf('currently %d players are online', $playersOnline));
    }
}