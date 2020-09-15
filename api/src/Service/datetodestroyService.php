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

use App\Entity\Adres;
//use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Client;
use Symfony\Component\Cache\Adapter\AdapterInterface as CacheInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class datetodestroyService
{
    private $config;
    private $params;
    private $client;
    private $commonGroundService;
    private $manager;
    /**
     * @var CacheInterface
     */
    private $cache;

    public function __construct(ParameterBagInterface $params, CacheInterface $cache, EntityManagerInterface $manager)
    {
        $this->params = $params;
        $this->cache = $cache;
        $this->manager = $manager;

        $this->client = new Client([
            // Base URI is used with relative requests
            'base_uri' => $this->params->get('common_ground.components')['chin']['checkins'],
            // You can set any number of default request options.
            'timeout'  => 4000.0,
            // This api key needs to go into params
            'headers' => ['X-Api-Key' => $this->params->get('common_ground.components')['chin']['apikey']],
        ]);
    }

    public function setConfig($config)
    {
        $this->config = $config;
    }

    public function executeDateCreatedOnDateToDestroy()
    {
        // Lets start with th getting of nummer aanduidingen
        $now = new \Datetime();
        if('dateToDestroy'=>$dateToDestroy == $now->format('Y-m-d')) {

        $this->commonGroundService->deleteResource();
        }

    }

}
