<?php

namespace App\DataFixtures;

use App\Entity\Amount;
use App\Entity\Project;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 0; $i < 50; $i++) {
            $project = new Project();
            $project->setName($faker->jobTitle());
            $amount = new Amount();
            $amount->setValue($faker->randomFloat());
            $amount->setCurrency('$');
            $project->setAmount($amount);
            $project->setStartDate($faker->dateTimeThisDecade());
            $manager->persist($project);

        }

        $manager->flush();
    }
}
