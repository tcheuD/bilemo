<?php

namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Common\Persistence\ObjectManager;

class ClientFixtures extends BaseFixtures
{
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'client', function($i) {

            $client = new Client();
            $client->setName($this->faker->lastName);
            $client->setEmail($this->faker->safeEmail);
            $client->setFirstname($this->faker->firstName());
            $client->setPassword('password'); //TODO: delete this & refactor asap

            return $client;
        });

        $manager->flush();
    }
}
