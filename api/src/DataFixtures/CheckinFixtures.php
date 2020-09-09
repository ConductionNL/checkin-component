<?php

namespace App\DataFixtures;

use App\Entity\Node;
use Conduction\CommonGroundBundle\Service\CommonGroundService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class CheckinFixtures extends Fixture
{
    private $commonGroundService;
    private $params;

    public function __construct(CommonGroundService $commonGroundService, ParameterBagInterface $params)
    {
        $this->commonGroundService = $commonGroundService;
        $this->params = $params;
    }

    public function load(ObjectManager $manager)
    {
        if (
            !$this->params->get('app_build_all_fixtures') &&
            $this->params->get('app_domain') != 'zuiddrecht.nl' && strpos($this->params->get('app_domain'), 'zuiddrecht.nl') == false &&
            $this->params->get('app_domain') != 'zuid-drecht.nl' && strpos($this->params->get('app_domain'), 'zuid-drecht.nl') == false
        ) {
            return false;
        }

        $node = new Node();
        $node->setName('Tafel 1');
        $node->setDescription('Tafel 1');
        $node->setReference('LQ0-578');
        $node->setPassthroughUrl('https://zuid-drecht.nl');
        $node->setPlace($this->commonGroundService->cleanUrl(['component'=>'lc', 'type'=>'places', 'id'=>'8f30215c-d778-480c-ac8c-8492d17c6a15']));
        $node->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'2106575d-50f3-4f2b-8f0f-a2d6bc188222']));
        $manager->persist($node);
        $manager->flush();

        $node = new Node();
        $node->setName('Tafel 2');
        $node->setDescription('Tafel 2');
        $node->setReference('TH6-7BS');
        $node->setPassthroughUrl('https://zuid-drecht.nl');
        $node->setPlace($this->commonGroundService->cleanUrl(['component'=>'lc', 'type'=>'places', 'id'=>'8f30215c-d778-480c-ac8c-8492d17c6a15']));
        $node->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'2106575d-50f3-4f2b-8f0f-a2d6bc188222']));
        $manager->persist($node);
        $manager->flush();

        $node = new Node();
        $node->setName('Bar');
        $node->setDescription('Bar');
        $node->setReference('ROW-OJ8');
        $node->setPassthroughUrl('https://zuid-drecht.nl');
        $node->setPlace($this->commonGroundService->cleanUrl(['component'=>'lc', 'type'=>'places', 'id'=>'8f30215c-d778-480c-ac8c-8492d17c6a15']));
        $node->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'2106575d-50f3-4f2b-8f0f-a2d6bc188222']));
        $manager->persist($node);
        $manager->flush();

        $node = new Node();
        $node->setName('Tafel 1');
        $node->setDescription('Tafel 1');
        $node->setReference('LT4-K75');
        $node->setPassthroughUrl('https://zuid-drecht.nl');
        $node->setPlace($this->commonGroundService->cleanUrl(['component'=>'lc', 'type'=>'places', 'id'=>'f5b473e9-a2d8-4383-b268-265c340f4bc5']));
        $node->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'a9398c45-7497-4dbd-8dd1-1be4f3384ed7']));
        $manager->persist($node);
        $manager->flush();

        $node = new Node();
        $node->setName('Tafel 2');
        $node->setDescription('Tafel 2');
        $node->setReference('IDP-DQK');
        $node->setPassthroughUrl('https://zuid-drecht.nl');
        $node->setPlace($this->commonGroundService->cleanUrl(['component'=>'lc', 'type'=>'places', 'id'=>'f5b473e9-a2d8-4383-b268-265c340f4bc5']));
        $node->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'a9398c45-7497-4dbd-8dd1-1be4f3384ed7']));
        $manager->persist($node);
        $manager->flush();

        $node = new Node();
        $node->setName('Graven zaal');
        $node->setDescription('Graven zaal');
        $node->setReference('I2K-HTI');
        $node->setPassthroughUrl('https://zuid-drecht.nl');
        $node->setPlace($this->commonGroundService->cleanUrl(['component'=>'lc', 'type'=>'places', 'id'=>'f5b473e9-a2d8-4383-b268-265c340f4bc5']));
        $node->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'a9398c45-7497-4dbd-8dd1-1be4f3384ed7']));
        $manager->persist($node);
        $manager->flush();

        $manager->flush();
    }
}