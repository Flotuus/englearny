<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Theme;


class AppFixtures extends Fixture
{
    private $manager;
    private $repoTheme;
    private $faker;

    public function __construct(){
        $this->faker=Factory::create("fr_FR");
    }


    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $repoUser = $this->manager->getRepository(Theme::class);
        $this->loadThemes();
        $manager->flush();
    }

    public function loadThemes(){
        for($i=0;$i<10;$i++){
            $theme = new Theme();
            $theme->setLibelle($this->)
     
            $this->addReference('user'.$i, $user);
            $this->manager->persist($user);
        }
        $user = new User();
        $user->setNom('LE GALES')
        ->setPrenom('julien')
        ->setEmail('julien.legales@gmail.com')
        ->setPassword('julien')
        ->setDateInscription(new \DateTime());
        $this->addReference('julien', $user);
        $this->manager->flush();

    }


}
