<?php

namespace App\DataFixtures;

use App\Entity\Pcstuff;
use App\Entity\Product;
use App\Entity\User;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class AppFixtures extends Fixture
{
    private $slugger;
    private $passwordEncoder;

    /**
     * Dans une classe d'un projet Symfony, on peut récupèrer n'importe quel service
     * via le constructeur
     */
    public function __construct(SluggerInterface $slugger, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->slugger = $slugger;
        $this->passwordEncoder = $passwordEncoder;
    }    
    
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

// ----------------------------------------------------------

$user = new User();
$user->setEmail('test@test.fr');
$user->setPassword( $this->passwordEncoder->encodePassword($user, 'test'));
$user->setRoles(['ROLE_ADMIN']);
$manager->persist($user);


//-----------------------------------------------------------

$stuffs = ['Clavier', 'Souris', 'Casque', 'Tapis de souris'];
foreach ($stuffs as $key => $stuff) {
    $pcstuff = new Pcstuff();
    $pcstuff->setName($stuff);
    $this->addReference('stuff-'.$key, $pcstuff);
    $manager->persist($pcstuff);
}

//-----------------------------------------------------------

        for ($i = 1; $i <= 100; $i++) {
            $product = new product();
            $pcstuff = $this->getReference('stuff-'.rand(0, count($stuffs)-1));

            $name = $faker->randomElement(['Razer', 'Logitech', 'Roccat', 'Asus', 'MSI']);
            $product->setName($name);

            $product->setSlug($this->slugger->slug($name)->lower());
            $product->setDescription($faker->text(255));
            $product->setPrice($faker->numberBetween(99, 5000));
            
            $product->setCreationdate($faker->dateTimeBetween('-2 years', 'today'));
            $product->setFavorite($faker->boolean(10));

            $color = $faker->randomElement(['blanc', 'noir', 'gris', 'rose', 'vert']);
            $product->setColor($color);

            $product->setPcstuff($pcstuff);

            $product->setImage($faker->randomElement([
             'fixtures/1.png', 'fixtures/2.png', 'fixtures/3.png', 'fixtures/4.png', 'fixtures/5.png', 'fixtures/6.png', 'fixtures/7.png', 'fixtures/8.png', 'fixtures/9.png'
            ]));
            $product->setPromotion($faker->boolean(10));

            $manager->persist($product);
        }

        $manager->flush();
    }
}
