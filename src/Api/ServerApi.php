<?php

declare(strict_types=1);

namespace App\Api;

use App\Api\Model\ServerGuid;
use CryoFallStatisticsApiClient\ApiException;
use CryoFallStatisticsApiClient\Api\ServerApi as CryoFallServerApi;
use CryoFallStatisticsApiClient\Configuration;
use CryoFallStatisticsApiClient\Model\LeaderboardResponse;
use DateTime;

class ServerApi
{
    private CryoFallServerApi $api;
    private ServerGuid $guid;

    public function __construct(ServerGuid $guid)
    {
        $this->guid = $guid;
        $config = new Configuration();
        $config->setHost('http://localhost/CryoFallApi/Public/index.php');

        $this->api = new CryoFallServerApi(null, $config);
    }

    /**
     * @throws ApiException
     */
    public function getPlayersOnline(): int
    {
        $ret = $this->api->getOnlineAction((string)$this->guid);
        return $ret->getPlayerOnline();
    }

    /**
     * @throws ApiException
     */
    public function getLeaderboard(?DateTime $from = null, ?DateTime $to = null): LeaderboardResponse
    {
        return $this->api->getLeaderboardAction(
            (string)$this->guid,
            null !== $from ? $from->format('c') : null,
            null !== $to ? $to->format('c') : null
        );
    }
}