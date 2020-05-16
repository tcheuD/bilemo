<?php

namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ClientFixtures extends BaseFixtures
{
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(10, 'client', function($i) {

            $client = new Client();
            $client->setName('dupont'.$i);
            $client->setEmail('dupont'.$i.'@dupont.fr');
            $client->setFirstname('jean'.$i);
            $client->setPassword($this->passwordEncoder->encodePassword(
                $client,
                'password'
            ));

            return $client;
        });

        $manager->flush();
    }
}
