<?php

// src/Command/CreateUserCommand.php

namespace App\Command;

use App\Service\CheckinService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ArchiveCommand extends Command
{

    private $checkinService;

    public function __construct(CheckinService $checkinService)
    {
        $this->checkinService = $checkinService;

        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
        ->setName('app:chin:archive')
        // the short description shown while running "php bin/console list"
        ->setDescription('Archives al checkins older then tair destroy date')
        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('Use carefully');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $result = $this->checkinService->archive();
    }
}
