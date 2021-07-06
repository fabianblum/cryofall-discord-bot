<?php

declare(strict_types=1);

namespace App\Actions;

use App\Api\ServerApi;
use CryoFallStatisticsApiClient\ApiException;
use Discord\Discord;
use Discord\Parts\Channel\Message;
use Exception;

class LeaderboardAction extends AbstractAction
{
    protected string $regex = '/^!leaderboard/';

    /**
     * @throws ApiException
     * @throws Exception
     */
    public function process(Message $message, Discord $discord): void
    {
        $api = new ServerApi($this->getBotConfig()->getServerGuid());
    }
}