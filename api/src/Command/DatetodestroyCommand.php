<?php

// src/Command/CreateUserCommand.php

namespace App\Command;

use App\Service\KadasterService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class DatetodestroyCommand extends Command
{
    private $em;
    private $datetodestroyService;

    public function __construct(EntityManagerInterface $em, DatetodestroyService $datetodestroyService)
    {
        $this->em = $em;
        $this->datetodestroyService = $datetodestroyService;

        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
        ->setName('app:datetodestroy')
        // the short description shown while running "php bin/console list"
        ->setDescription('Destroys all checkins older than 14 days')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('This command destroys all checkins older than 14 days')
        ->setDescription('Destroy all checkins older than 14 days')
        ->addOption('dateCreated', null, InputOption::VALUE_OPTIONAL, 'the date of creation of the checkins')
        ->addOption('dateToDestroy', null, InputOption::VALUE_OPTIONAL, 'the date of destruction of the checkins');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        /** @var string $version */
        $this->datetodestroyService->executeDateCreatedOnDateToDestroy();
    }
}
