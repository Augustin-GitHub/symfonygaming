<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;

class AppFixtures extends Fixture
{
    private $slugger;

    /**
     * Dans une classe d'un projet Symfony, on peut récupèrer n'importe quel service
     * via le constructeur
     */
    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }    
    
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 1; $i <= 100; $i++) {
            $product = new product();

            $name = $faker->randomElement(['Razer', 'Logitech', 'Roccat', 'Asus', 'MSI']);
            $product->setName($name);

            $product->setSlug($this->slugger->slug($name)->lower());
            $product->setDescription($faker->text(255));
            $product->setPrice($faker->numberBetween(99, 5000));
            
            $product->setCreationdate($faker->dateTimeBetween('-2 years', 'today'));
            $product->setFavorite($faker->boolean(10));

            $color = $faker->randomElement(['blanc', 'noir', 'gris', 'rose', 'vert']);
            $product->setColor($color);

            $product->setImage($faker->randomElement([
             'fixtures/1.png', 'fixtures/2.png', 'fixtures/3.png', 'fixtures/4.png', 'fixtures/5.png', 'fixtures/6.png', 'fixtures/7.png', 'fixtures/8.png', 'fixtures/9.png'
            ]));
            $product->setPromotion($faker->boolean(10));
            $manager->persist($product);
        }

        $manager->flush();
    }
}
