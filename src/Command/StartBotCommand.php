<?php

declare(strict_types=1);

namespace App\Command;

use App\Actions\ActionService;
use App\Configuration\BotConfiguration;
use App\Listener\ListenerService;
use App\Service\Bot;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StartBotCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'bot:start';

    protected function configure(): void
    {
        // ...
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $configuration = new BotConfiguration();

        try {
            $botService = new Bot(new ListenerService(new ActionService()), (string)$configuration->getToken());
            $botService->run();
            return Command::SUCCESS;
        } catch (\Exception $e) {
            printf($e->getMessage());
        }

        return Command::FAILURE;
    }
}
