<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Theme;
use App\Entity\Categorie;
use App\Entity\Test;
use App\Entity\Mot;
use App\Entity\Entreprise;
use App\Entity\Role;
use App\Entity\Abonnement;



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
        $this->loadEntreprises();
        $this->loadRoles();
        $this->loadAbonnements();
        $this->loadMots();
        $this->loadTest();
        $manager->flush();
    }

    public function loadThemes(){
        $listeTheme = ["Animaux","Corps Humain","Vegetation","Legumes","Fruits","Automobile","Technologies","Meubles","Batiments","Agriculture"];

        for($i=0;$i<10;$i++){
            $theme = new Theme();
            $theme->setLibelle($listeTheme[$i]);
     
            $this->addReference('theme'.$i, $theme);
            $this->manager->persist($theme);
        }
    

    }

    public function loadCategories()
    {
        $listeCategorie = ["Nom","Verbe","Adjectif","Adverbe","Pronom","Determinant","Conjonction","Preposition","Interjection"];
        for($i=0;$i<9;$i++){
            $categorie = new Categorie();
            $categorie->setLibelle($listeCategorie[$i]);

            $this->addReference('categorie'.$i, $categorie);
            $this->manager->persist($categorie);
        }


    }

    public function loadMots()
    {
        $listeMots = ["Table","Speak","Pretty","Slowly","He","The","When","On","Alas"];
        for($i=0;$i<9;$i++){
            $mot = new Mot();
            $mot->setLibelle($listeMots[$i]);
            $mot->setCategorie($this->getReference('categorie'.$i));

            $this->addReference('mot'.$i, $mot);
            $this->manager->persist($mot);
        }

    }

    public function loadTest()
    {
        for($i=0;$i<9;$i++){
            $test = new Test();
            $test->setLibelle('test'.$i);
            $test->setNiveau($i);
            $test->setTheme($this->getReference('theme'.$i));
            $this->addReference('test'.$i, $test);
            $this->manager->persist($test);
        }
    }

    public function loadEntreprises()
    {
        for($i=0;$i<10;$i++){
            $entreprise = new Entreprise();
            $entreprise->setLibelle($this->faker->company);
            $this->addReference('entreprise'.$i, $entreprise);
            $this->manager->persist($entreprise);
        }
    }

    public function loadRoles()
    {



        
    }

    public function loadAbonnements()
    {

    }

}
