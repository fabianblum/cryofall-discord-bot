<?php

declare(strict_types=1);

namespace App\Configuration;

use App\Api\Model\ServerGuid;
use App\Api\Model\Token;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class BotConfiguration
{
    private mixed $botConfigs;

    public function __construct()
    {
        try {
            $this->botConfigs = Yaml::parseFile(__DIR__.'/../../config/bot.yaml');
        } catch (ParseException $exception) {
            printf('Unable to parse the YAML string: %s', $exception->getMessage());
        }
    }

    public function getServerGuid(): ServerGuid
    {
        return new ServerGuid($this->botConfigs['bot']['server_guid']);
    }

    public function getToken(): Token
    {
        $token = getenv('DISCORD_TOKEN');
        return new Token($token);
    }
}
