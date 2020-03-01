<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Common\Persistence\ObjectManager;

class ProductFixtures extends BaseFixtures
{
    private static $operatingSystem = [
        'Android',
        'Ios'
    ];

    private static $displayType = [
        'LCD',
        'OLED',
        'AMOLED'
    ];

    private static $resolution = [
        '720×1280',
        '1920×1080',
        '2560×1440',
        '1440×2560'
    ];

    private static $model = [
        'S10 Plus',
        'Note 10 Plus',
        'Pro Max',
        'Pixel 3',
        'S10e',
        '7 Pro',
        'P30 Pro',
        'S10',
        'XR',
        '20 Pro',
        'XS',
        'Pixel 3 XL',
        'Galaxy S9 Plus',
        'Galaxy Note 9'
    ];

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'product', function($i) {
            $product = new Product();
            $product->setOperatingSystem(self::$operatingSystem[array_rand(self::$operatingSystem)]);
            $product->setName('phone'.$i);
            $product->setReleaseDate($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $product->setColor($this->faker->colorName);
            $product->setBrand($this->faker->company);
            $product->setPrice(rand(70, 999));
            $product->setDisplayType(self::$displayType[array_rand(self::$displayType)]);
            $product->setResolution(self::$resolution[array_rand(self::$resolution)]);
            $product->setBattery('1960 mAh ');
            $product->setModel(self::$model[$i]);
            $product->setWeight(rand(120, 200));
            $product->setStock(rand(0, 100));
            $product->setProductDescription($this->faker->text(100));



            return $product;
        });

        $manager->flush();

    }
}
