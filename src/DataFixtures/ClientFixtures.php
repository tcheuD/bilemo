<?php

namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ClientFixtures extends BaseFixtures
{
    private UserPasswordEncoderInterface $passwordEncoder;

    private static array $lastName = [
        'dupont',
        'dupont2',
        'dupont3',
        'dupont4',
        'dupont5',
        'dupont6',
        'dupont7',
        'dupont8',
        'dupont9',
        'dupont10',
    ];

    private static array $firstName = [
        'jean',
        'jean2',
        'jean3',
        'jean4',
        'jean5',
        'jean6',
        'jean7',
        'jean8',
        'jean9',
        'jean10',
    ];

    private static array $email = [
        'dupont@dupont.fr',
        'dupont2@dupont.fr',
        'dupont3@dupont.fr',
        'dupont4@dupont.fr',
        'dupont5@dupont.fr',
        'dupont6@dupont.fr',
        'dupont7@dupont.fr',
        'dupont8@dupont.fr',
        'dupont9@dupont.fr',
        'dupont10@dupont.fr',
    ];

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(10, 'client', function($i) {

            $client = new Client();
            $client->setName(self::$lastName[$i]);
            $client->setEmail(self::$email[$i]);
            $client->setFirstname(self::$firstName[$i]);
            $client->setPassword($this->passwordEncoder->encodePassword(
                $client,
                'password'
            ));

            return $client;
        });

        $manager->flush();
    }
}
