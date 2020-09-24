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
        $node->setAccommodation($this->commonGroundService->cleanUrl(['component'=>'lc', 'type'=>'accommodations', 'id'=>'75f36e60-c798-41bb-ae11-4bc4e23aa147']));
        $node->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'2106575d-50f3-4f2b-8f0f-a2d6bc188222']));
        $manager->persist($node);
        $manager->flush();

        $node = new Node();
        $node->setName('Tafel 2');
        $node->setDescription('Tafel 2');
        $node->setReference('TH6-7BS');
        $node->setPassthroughUrl('https://zuid-drecht.nl');
        $node->setAccommodation($this->commonGroundService->cleanUrl(['component'=>'lc', 'type'=>'accommodations', 'id'=>'014016d0-292e-4373-8bd2-4a0e427ac059']));
        $node->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'2106575d-50f3-4f2b-8f0f-a2d6bc188222']));
        $manager->persist($node);
        $manager->flush();

        $node = new Node();
        $node->setName('Bar');
        $node->setDescription('Bar');
        $node->setReference('ROW-OJ8');
        $node->setPassthroughUrl('https://zuid-drecht.nl');
        $node->setAccommodation($this->commonGroundService->cleanUrl(['component'=>'lc', 'type'=>'accommodations', 'id'=>'51c8a9f-f7cf-4f45-9c16-72ed74d4eba1']));
        $node->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'2106575d-50f3-4f2b-8f0f-a2d6bc188222']));
        $manager->persist($node);
        $manager->flush();

        $node = new Node();
        $node->setName('Tafel 1');
        $node->setDescription('Tafel 1');
        $node->setReference('LT4-K75');
        $node->setPassthroughUrl('https://zuid-drecht.nl');
        $node->setAccommodation($this->commonGroundService->cleanUrl(['component'=>'lc', 'type'=>'accommodations', 'id'=>'c6f5ec24-7321-4176-a588-a3bb0bf2b62e']));
        $node->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'a9398c45-7497-4dbd-8dd1-1be4f3384ed7']));
        $manager->persist($node);
        $manager->flush();

        $node = new Node();
        $node->setName('Tafel 2');
        $node->setDescription('Tafel 2');
        $node->setReference('IDP-DQK');
        $node->setPassthroughUrl('https://zuid-drecht.nl');
        $node->setAccommodation($this->commonGroundService->cleanUrl(['component'=>'lc', 'type'=>'accommodations', 'id'=>'f5b473e9-a2d8-4383-b268-265c340f4bc5']));
        $node->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'a9398c45-7497-4dbd-8dd1-1be4f3384ed7']));
        $manager->persist($node);
        $manager->flush();

        $node = new Node();
        $node->setName('Graven zaal');
        $node->setDescription('Graven zaal');
        $node->setReference('I2K-HTI');
        $node->setPassthroughUrl('https://zuid-drecht.nl');
        $node->setAccommodation($this->commonGroundService->cleanUrl(['component'=>'lc', 'type'=>'accommodations', 'id'=>'9f847ce1-eeb6-4e86-ad58-86dda3e18302']));
        $node->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'f302b75e-a233-4ddf-95b5-f8603f2e80e9']));
        $manager->persist($node);
        $manager->flush();

        $node = new Node();
        $node->setName('Mc Donalds Zuid-Drecht');
        $node->setReference('KE8-07I');
        $node->setDescription('Mc Donalds Zuid-Drecht');
        $node->setPassthroughUrl('https://www.mcdonalds.com/nl/nl-nl.html');
        $node->setAccommodation($this->commonGroundService->cleanUrl(['component'=>'lc', 'type'=>'accommodations', 'id'=>'d7aa6399-88b8-4451-9c23-dd15ca1719b5']));
        $node->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'e3137e4f-e44d-4400-adbd-0fa1b4be9d65']));
        $manager->persist($node);
        $manager->flush();

        $node = new Node();
        $node->setName('Emmalaan 7');
        $node->setReference('9NV-JYR');
        $node->setMethods([
            'facebook'  => true,
            'google'    => true,
        ]);
        $node->setDescription('Emmalaan 7');
        $node->setReference('9NV-JYR');
        //$node->setPassthroughUrl('https://creativegrounds.com/');
        $node->setAccommodation($this->commonGroundService->cleanUrl(['component'=>'lc', 'type'=>'accommodations', 'id'=>'d96c8148-16f0-4f0b-9010-e1025b9cb6f1']));
        $node->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'62bff497-cb91-443e-9da9-21a0b38cd536']));
        $manager->persist($node);
        $manager->flush();

        $node = new Node();
        $node->setName('Emmalaan 9');
        $node->setDescription('Emmalaan 9');
        $node->setReference('7U1-Y80');
        $node->setMethods([
            'facebook'  => true,
            'google'    => true,
        ]);
        //$node->setPassthroughUrl('https://creativegr ounds.com/');
        $node->setAccommodation($this->commonGroundService->cleanUrl(['component'=>'lc', 'type'=>'accommodations', 'id'=>'ee032543-1828-4e45-b08d-13b4581458ef']));
        $node->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'62bff497-cb91-443e-9da9-21a0b38cd536']));
        $manager->persist($node);

        $manager->flush();
    }
}
