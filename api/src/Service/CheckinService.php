<?php

// Conduction/CommonGroundBundle/Service/KadasterService.php

/*
 * This file is part of the Conduction Common Ground Bundle
 *
 * (c) Conduction <info@conduction.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service;

use App\Entity\Checkin;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CheckinService
{
    private $em;

    public function __construct(
        EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function setConfig($config)
    {
        $this->config = $config;
    }

    public function archive()
    {
        // Alles ophalen wat gearchiveer moet worden

        $stmt = $this->em
            ->getRepository('App\Entity\Checkin')
            ->archive();

        $stmt->execute();

        // Dat dan archiveren

    }
}
