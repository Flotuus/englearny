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
use App\Entity\Liste;


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
        $this->loadListe();
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
        $listeMots1 =["Table","Speak","Pretty","Slowly","He","The","When","On","Alas"]; 
        $listeMots2 = ["Chair","Write","Tall","Easily","I","That","And","About","Jeez"];
        $listeMots3 = ["Desk","Share","Strong","Lately","We","This","Or","Until","Man"];
        $listeMots4 = ["Phone","Make","Hard","Quickly","You","These","Nor","Within","Awesome"];
        $listeMots5 = ["Computer","Pull","Fast","Recently","They","Those","Neither","Behind","Finnaly"];
        $listeMotsTraduits1 = ["Table","Parler","Joli","Lentement","Il","Le","Quand","Sur","Helas"];
        $listeMotsTraduits2 = ["Chaise","Ecrire","Grand","Facilement","Je","Cela","Et","Environ","Mon Dieu"];
        $listeMotsTraduits3 = ["Bureau","Partager","Fort","Dernierement","Nous","Ceci","Ou","Jusqu\'a","Mec"];
        $listeMotsTraduits4 = ["Telephone","Faire","Difficile","Rapidement","Tu","Ces","Ni","Parmi","Genial"];
        $listeMotsTraduits5 = ["Ordinateur","Tirer","Rapide","Recemment","Ils","Ces","Aucun","Derriere","Enfin"];
        
            for($i=0,$j=0;$i<9;$i++,$j++){
                $mot = new Mot();
                $mot->setLibelle($listeMots1[$i]);
                $mot->setTraduction($listeMotsTraduits1[$i]);
                $mot->setCategorie($this->getReference('categorie'.$i));

                $this->addReference('mot'.$j, $mot);
                $this->manager->persist($mot);
            }

            for($i=0,$j;$i<9;$i++,$j++){
                $mot = new Mot();
                $mot->setLibelle($listeMots2[$i]);
                $mot->setTraduction($listeMotsTraduits2[$i]);
                $mot->setCategorie($this->getReference('categorie'.$i));

                $this->addReference('mot'.$j, $mot);
                $this->manager->persist($mot);
            }

            for($i=0,$j;$i<9;$i++,$j++){
                $mot = new Mot();
                $mot->setLibelle($listeMots3[$i]);
                $mot->setTraduction($listeMotsTraduits3[$i]);
                $mot->setCategorie($this->getReference('categorie'.$i));

                $this->addReference('mot'.$j, $mot);
                $this->manager->persist($mot);
            }

            for($i=0,$j;$i<9;$i++,$j++){
                $mot = new Mot();
                $mot->setLibelle($listeMots4[$i]);
                $mot->setTraduction($listeMotsTraduits4[$i]);
                $mot->setCategorie($this->getReference('categorie'.$i));

                $this->addReference('mot'.$j, $mot);
                $this->manager->persist($mot);
            }

            for($i=0,$j;$i<9;$i++,$j++){
                $mot = new Mot();
                $mot->setLibelle($listeMots5[$i]);
                $mot->setTraduction($listeMotsTraduits5[$i]);
                $mot->setCategorie($this->getReference('categorie'.$i));

                $this->addReference('mot'.$j, $mot);
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

    public function loadListe()
    {
        
        $liste = new Liste();
        $liste->setLibelle('listeMeuble1');
        $liste->setEntreprise($this->getReference('entreprise0'));
        $liste->setTheme($this->getReference('theme7'));
        $this->addReference('liste0', $liste);
        $liste->addMot($this->getReference('mot0'));
        $liste->addMot($this->getReference('mot10'));
        $liste->addMot($this->getReference('mot20'));

        $this->manager->persist($liste);

        
        $liste = new Liste();
        $liste->setLibelle('listeTechs1');
        $liste->setEntreprise($this->getReference('entreprise1'));
        $liste->setTheme($this->getReference('theme6'));
        $this->addReference('liste1', $liste);
        $liste->addMot($this->getReference('mot30'));
        $liste->addMot($this->getReference('mot40'));
        $this->manager->persist($liste);

    }


}
