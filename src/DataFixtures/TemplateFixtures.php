<?php

namespace App\DataFixtures;

use App\Entity\Tests;
use App\Entity\Server;
use App\Entity\Service;
use App\Entity\Template;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class TemplateFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $template1 = new Template();
        $template1->setTemplateName('Grrrrr');
        $template1->setTestCode('test code for Grrrrr');
        $template1->setExpectedAnswer('expected answer for Grrrrr');
        $manager->persist($template1);

        $template2 = new Template();
        $template2->setTemplateName('Rory');
        $template2->setTestCode('test code for Rory');
        $template2->setExpectedAnswer('expected answer for Rory');
        $manager->persist($template2);


        $template3 = new Template();
        $template3->setTemplateName('Heager');
        $template3->setTestCode('test code for Heager');
        $template3->setExpectedAnswer('expected answer for Heager');
        $manager->persist($template3);

        $manager->flush();
        

    }
}
