<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CustomerFixtures extends BaseFixtures implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(100, 'customer', function($i) {

            $customer = new Customer();
            $customer->setFirstname($this->faker->firstName());
            $customer->setName($this->faker->lastName);
            $customer->setEmail($this->faker->safeEmail);
            $customer->setAdress($this->faker->streetAddress);
            $customer->setCity($this->faker->city);
            $customer->setPostalCode((int)$this->faker->postcode);
            $customer->setClient($this->getReference('client_'.$this->floor10($i)));

            return $customer;
        });

        $manager->flush();
    }

    /**
     * @param $input
     * @return float|int
     */
    private function floor10($input)
    {
        $input /= 10;
        $input = floor($input);
        $input = 10*$input;

        return $input/10;
    }

    public function getDependencies()
    {
        return [
            ClientFixtures::class
        ];
    }
}
