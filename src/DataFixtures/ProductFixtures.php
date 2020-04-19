<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Common\Persistence\ObjectManager;

class ProductFixtures extends BaseFixtures
{
    private static array $operatingSystem = [
        'Android',
        'Ios'
    ];

    private static array $displayType = [
        'LCD',
        'OLED',
        'AMOLED'
    ];

    private static array $resolution = [
        '720×1280',
        '1920×1080',
        '2560×1440',
        '1440×2560'
    ];

    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(10, 'product', function($i) {
            $product = new Product();
            $product->setOperatingSystem(self::$operatingSystem[array_rand(self::$operatingSystem)]);
            $product->setName('phone'.$i);
            $product->setReleaseDate($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $product->setColor($this->faker->colorName);
            $product->setBrand($this->faker->company);
            $product->setPrice(random_int(70, 999));
            $product->setDisplayType(self::$displayType[array_rand(self::$displayType)]);
            $product->setResolution(self::$resolution[array_rand(self::$resolution)]);
            $product->setBattery('1960 mAh ');
            $product->setWeight(random_int(120, 200));
            $product->setStock(random_int(0, 100));
            $product->setProductDescription($this->faker->text(100));

            return $product;
        });

        $manager->flush();

    }
}
