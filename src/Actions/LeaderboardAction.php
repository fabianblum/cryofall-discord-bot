<?php

declare(strict_types=1);

namespace App\Actions;

use App\Api\ServerApi;
use App\Trait\DiscordTools;
use CryoFallStatisticsApiClient\ApiException;
use DateTime;
use Discord\Discord;
use Discord\Parts\Channel\Message;
use Exception;

class LeaderboardAction extends AbstractAction
{
    use DiscordTools;

    protected string $regex = '/^\!leaderboard([\sa-zA-Z]*)/';

    /**
     * @throws ApiException
     * @throws Exception
     */
    public function process(Message $message, Discord $discord, array $matches): void
    {
        $api = new ServerApi($this->getBotConfig()->getServerGuid());

        $from = null;
        $to = null;
        if (isset($matches[1])) {
            switch (trim($matches[1])) {
                case 'today':
                    $from = new DateTime('today');
                    $to = new DateTime();
                    break;
                case 'yesterday':
                    $from = new DateTime('yesterday');
                    $to = new DateTime('today');
                    break;
            }
        }

        $leaderboard = $api->getLeaderboard($from, $to);

        $pvpKills = array_slice($leaderboard->getPvp(), 0, 10);
        $pveKills = array_slice($leaderboard->getPve(), 0, 10);

        $arrPvPKills = [];
        foreach ($pvpKills as $kill) {
            $arrPvPKills[] = ["Player" => $kill->getPlayer(), "kills" => (string)$kill->getKills()];
        }

        $arrPvEKills = [];
        foreach ($pveKills as $kill) {
            $arrPvEKills[] = ["Player" => $kill->getPlayer(), "kills" => (string)$kill->getKills()];
        }

        $msg = '';
        if ($arrPvPKills) {
            $msg .= sprintf("TOP 10: Player Kills \n```%s```", $this->arr2textTable($arrPvPKills));
        }

        if ($arrPvEKills) {
            $msg .= sprintf("\nTOP 10: NPC Kills \n```%s```", $this->arr2textTable($arrPvEKills));
        }

        if ($msg) {
            $message->reply($msg);
        } else {
            $message->reply('No results found');
        }
    }
}