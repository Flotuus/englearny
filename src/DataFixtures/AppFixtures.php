<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Theme;
use App\Entity\Categorie;
use App\Entity\Test;



class AppFixtures extends Fixture
{
    private $manager;
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
        $listeTheme = ["Animaux","Corps Humain","Vegetation","Legumes","Fruits","Automobile","Technologies","Meubles","Batiments" ];

        for($i=0;$i<10;$i++){
            $theme = new Theme();
            $theme->setLibelle($listeTheme[$i])
     
            $this->addReference('theme'.$i, $theme);
            $this->manager->persist($theme);
        }
    
        $this->manager->flush();

    }


}
