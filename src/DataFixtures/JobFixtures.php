<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Job;
use Faker\Factory;
use Faker\Generator;

class JobFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $validUrls = ['https://google.com', 'https://www.wikipedia.com', 'https://example.com', 'https://www.stackoverflow.com'];

        foreach ($validUrls as $url) {
            $job = new Job();
            $job->setUrl($url);
            $manager->persist($job);
        }

        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 30; $i++) {
            $job = new Job();
            $job->setUrl($faker->url);
            $manager->persist($job);
        }

        $manager->flush();
    }
}
