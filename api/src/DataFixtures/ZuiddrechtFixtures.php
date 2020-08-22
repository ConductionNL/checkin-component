<?php

namespace App\DataFixtures;

use App\Entity\Node;
use Conduction\CommonGroundBundle\Service\CommonGroundService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Ramsey\Uuid\Uuid;
use DateTime;

class ZuiddrechtFixtures extends Fixture
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

        $node = New Node();
        $node->setName('Tafel 1');
        $node->setDescription('Tafel 1');
        $node->setPlace($this->commonGroundService->cleanUrl(['component'=>'lc', 'type'=>'places', 'id'=>'75f36e60-c798-41bb-ae11-4bc4e23aa147']));
        $node->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $manager->persist($node);
        $manager->flush();

        $node = New Node();
        $node->setName('Tafel 2');
        $node->setDescription('Tafel 2');
        $node->setPlace($this->commonGroundService->cleanUrl(['component'=>'lc', 'type'=>'places', 'id'=>'014016d0-292e-4373-8bd2-4a0e427ac059']));
        $node->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $manager->persist($node);
        $manager->flush();

        $node = New Node();
        $node->setName('Bar');
        $node->setDescription('Bar');
        $node->setPlace($this->commonGroundService->cleanUrl(['component'=>'lc', 'type'=>'places', 'id'=>'751c8a9f-f7cf-4f45-9c16-72ed74d4eba1']));
        $node->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $manager->persist($node);
        $manager->flush();

        $node = New Node();
        $node->setName('Tafel 1');
        $node->setDescription('Tafel 1');
        $node->setPlace($this->commonGroundService->cleanUrl(['component'=>'lc', 'type'=>'places', 'id'=>'c6f5ec24-7321-4176-a588-a3bb0bf2b62e']));
        $node->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $manager->persist($node);
        $manager->flush();

        $node = New Node();
        $node->setName('Tafel 2');
        $node->setDescription('Tafel 2');
        $node->setPlace($this->commonGroundService->cleanUrl(['component'=>'lc', 'type'=>'places', 'id'=>'21cc4b1f-f9d6-4059-95e3-67535d5dfb9a']));
        $node->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $manager->persist($node);
        $manager->flush();

        $node = New Node();
        $node->setName('Graven zaal');
        $node->setDescription('Graven zaal');
        $node->setPlace($this->commonGroundService->cleanUrl(['component'=>'lc', 'type'=>'places', 'id'=>'9f847ce1-eeb6-4e86-ad58-86dda3e18302']));
        $node->setOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'4d1eded3-fbdf-438f-9536-8747dd8ab591']));
        $manager->persist($node);
        $manager->flush();

        $manager->flush();
    }
}
