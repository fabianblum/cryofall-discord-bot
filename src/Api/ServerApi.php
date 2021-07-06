<?php

declare(strict_types=1);

namespace App\Api;

use App\Api\Model\ServerGuid;
use CryoFallStatisticsApiClient\ApiException;
use CryoFallStatisticsApiClient\Api\ServerApi as CryoFallServerApi;

class ServerApi
{
    private CryoFallServerApi $api;
    private ServerGuid $guid;

    public function __construct(ServerGuid $guid)
    {
        $this->guid = $guid;
        $this->api = new CryoFallServerApi();
    }

    /**
     * @throws ApiException
     */
    public function getPlayersOnline(): int
    {
        return (int)$this->api->getOnlineAction((string)$this->guid);
    }
}