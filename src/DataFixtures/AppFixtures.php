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
        $this->loadThemes();
        $this->loadCategories();
        $this->loadMots();
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
    

    }

    public function loadCategories()
    {
        $listeCategorie = ["Nom","Verbe","Adjectif","Adverbe","Pronom","Determinant","Conjonction","Preposition","Interjection"];
        for($j=0;$j<9;$j++){
            $categorie = new Categorie();
            $categorie->setLibelle($listeCategorie[$j]);

            $this->addReference('categorie'.$j, $categorie);
            $this->manager->persist($categorie);
        }


    }

    public function loadMots()
    {
        $listeMots = ["Table","Speak","Pretty","Slowly","He","The","When","On","Alas"];
        for($j=0;$j<9;$j++){
            $mot = new Mot();
            $mot->setLibelle($listeMots[$j]);
            $mot->setCategorie(getReference('categorie'.$j);

            $this->addReference('mot'.$j, $mot);
            $this->manager->persist($mot);
        }

    }


}
