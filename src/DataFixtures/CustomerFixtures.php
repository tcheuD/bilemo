<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CustomerFixtures extends BaseFixtures implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'customer', function($i) {

            $customer = new Customer();
            $customer->setFirstname($this->faker->firstName());
            $customer->setName($this->faker->lastName);
            $customer->setEmail($this->faker->safeEmail);
            $customer->setAdress($this->faker->streetAddress);
            $customer->setCity($this->faker->city);
            $customer->setPostalCode(intval($this->faker->postcode));
            $customer->setClient($this->getRandomReference('client'));

            return $customer;
        });

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ClientFixtures::class
        ];
    }
}
