<?php

namespace App\DataFixtures;

use App\Entity\Developer;
use App\Entity\Game;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Création des jeux
        $jeu1 = new Game();
        $jeu1->setTitle("The Legend of Zelda: Breath of the Wild");
        $jeu1->setReleaseDate(new \DateTime('2017-03-03'));
        $jeu1->setPrice(69.99);
        $jeu1->setGenre("Action-Aventure");
        $manager->persist($jeu1);

        $jeu2 = new Game();
        $jeu2->setTitle("Mario Kart 8 Deluxe");
        $jeu2->setReleaseDate(new \DateTime('2017-04-28'));
        $jeu2->setPrice(59.99);
        $jeu2->setGenre("Course, Arcade");
        $manager->persist($jeu2);

        $jeu3 = new Game();
        $jeu3->setTitle("Mortal Kombat 11");
        $jeu3->setReleaseDate(new \DateTime('2019-04-23'));
        $jeu3->setPrice(59.99);
        $jeu3->setGenre("Combat, Action");
        $manager->persist($jeu3);

        $jeu4 = new Game();
        $jeu4->setTitle("Sonic Mania");
        $jeu4->setReleaseDate(new \DateTime('2017-08-15'));
        $jeu4->setPrice(19.99);
        $jeu4->setGenre("Plateforme, Aventure");
        $manager->persist($jeu4);

        $jeu5 = new Game();
        $jeu5->setTitle("Rayman Legends");
        $jeu5->setReleaseDate(new \DateTime('2013-08-30'));
        $jeu5->setPrice(29.99);
        $jeu5->setGenre("Plateforme, Aventure");
        $manager->persist($jeu5);

        $jeu6 = new Game();
        $jeu6->setTitle("Street Fighter V");
        $jeu6->setReleaseDate(new \DateTime('2016-02-16'));
        $jeu6->setPrice(39.99);
        $jeu6->setGenre("Combat");
        $manager->persist($jeu6);

        $jeu7 = new Game();
        $jeu7->setTitle("Super Smash Bros. Ultimate");
        $jeu7->setReleaseDate(new \DateTime('2018-12-07'));
        $jeu7->setPrice(59.99);
        $jeu7->setGenre("Combat, Party");
        $manager->persist($jeu7);

        $jeu8 = new Game();
        $jeu8->setTitle("Overwatch");
        $jeu8->setReleaseDate(new \DateTime('2016-05-24'));
        $jeu8->setPrice(39.99);
        $jeu8->setGenre("Shooter, Combat d'équipe");
        $manager->persist($jeu8);

        $jeu9 = new Game();
        $jeu9->setTitle("Fortnite");
        $jeu9->setReleaseDate(new \DateTime('2017-07-25'));
        $jeu9->setPrice(0);
        $jeu9->setGenre("Battle Royale, Action");
        $manager->persist($jeu9);

        $jeu10 = new Game();
        $jeu10->setTitle("FIFA 22");
        $jeu10->setReleaseDate(new \DateTime('2021-10-01'));
        $jeu10->setPrice(59.99);
        $jeu10->setGenre("Sport, Simulation");
        $manager->persist($jeu10);

        $jeu11 = new Game();
        $jeu11->setTitle("Animal Crossing: New Horizons");
        $jeu11->setReleaseDate(new \DateTime('2020-03-20'));
        $jeu11->setPrice(59.99);
        $jeu11->setGenre("Simulation, Vie virtuelle");
        $manager->persist($jeu11);

        $jeu12 = new Game();
        $jeu12->setTitle("Cyberpunk 2077");
        $jeu12->setReleaseDate(new \DateTime('2020-12-10'));
        $jeu12->setPrice(59.99);
        $jeu12->setGenre("RPG, Action");
        $manager->persist($jeu12);

        $jeu13 = new Game();
        $jeu13->setTitle("Final Fantasy VII Remake");
        $jeu13->setReleaseDate(new \DateTime('2020-04-10'));
        $jeu13->setPrice(59.99);
        $jeu13->setGenre("RPG, Aventure");
        $manager->persist($jeu13);

        $jeu14 = new Game();
        $jeu14->setTitle("Tetris 99");
        $jeu14->setReleaseDate(new \DateTime('2019-02-13'));
        $jeu14->setPrice(0);
        $jeu14->setGenre("Puzzle, Battle Royale");
        $manager->persist($jeu14);

        $jeu15 = new Game();
        $jeu15->setTitle("Super Mario Odyssey");
        $jeu15->setReleaseDate(new \DateTime('2017-10-27'));
        $jeu15->setPrice(59.99);
        $jeu15->setGenre("Aventure, Plateforme");
        $manager->persist($jeu15);


        // Création des développeurs
        $nintendo = new Developer();
        $nintendo->setName("Nintendo");
        $nintendo->setCountry("Japan");
        $nintendo->setFounded(new \DateTime('1889-09-23'));
        $manager->persist($nintendo);

        $netherrealm = new Developer();
        $netherrealm->setName("NetherRealm Studios");
        $netherrealm->setCountry("USA");
        $netherrealm->setFounded(new \DateTime('2010-04-19'));
        $manager->persist($netherrealm);

        $sega = new Developer();
        $sega->setName("SEGA");
        $sega->setCountry("Japan");
        $sega->setFounded(new \DateTime('1960-06-03'));
        $manager->persist($sega);

        $ubisoft = new Developer();
        $ubisoft->setName("Ubisoft");
        $ubisoft->setCountry("France");
        $ubisoft->setFounded(new \DateTime('1986-03-28'));
        $manager->persist($ubisoft);

        $capcom = new Developer();
        $capcom->setName("Capcom");
        $capcom->setCountry("Japan");
        $capcom->setFounded(new \DateTime('1979-05-30'));
        $manager->persist($capcom);

        $blizzard = new Developer();
        $blizzard->setName("Blizzard Entertainment");
        $blizzard->setCountry("USA");
        $blizzard->setFounded(new \DateTime('1991-02-08'));
        $manager->persist($blizzard);

        $epic = new Developer();
        $epic->setName("Epic Games");
        $epic->setCountry("USA");
        $epic->setFounded(new \DateTime('1991-01-01'));
        $manager->persist($epic);

        $ea = new Developer();
        $ea->setName("Electronic Arts");
        $ea->setCountry("USA");
        $ea->setFounded(new \DateTime('1982-05-28'));
        $manager->persist($ea);

        $cdProjekt = new Developer();
        $cdProjekt->setName("CD Projekt Red");
        $cdProjekt->setCountry("Poland");
        $cdProjekt->setFounded(new \DateTime('2002-05-01'));
        $manager->persist($cdProjekt);

        $squareEnix = new Developer();
        $squareEnix->setName("Square Enix");
        $squareEnix->setCountry("Japan");
        $squareEnix->setFounded(new \DateTime('1986-04-01'));
        $manager->persist($squareEnix);

        // Associer les jeux aux développeurs
        /*
        $jeu1->setDeveloper($nintendo);
        $jeu2->setDeveloper($nintendo);
        $jeu3->setDeveloper($netherrealm);
        $jeu4->setDeveloper($sega);
        $jeu5->setDeveloper($ubisoft);
        $jeu6->setDeveloper($capcom);
        $jeu7->setDeveloper($nintendo);
        $jeu8->setDeveloper($blizzard);
        $jeu9->setDeveloper($epic);
        $jeu10->setDeveloper($ea);
        $jeu11->setDeveloper($nintendo);
        $jeu12->setDeveloper($cdProjekt);
        $jeu13->setDeveloper($squareEnix);
        $jeu14->setDeveloper($nintendo);
        $jeu15->setDeveloper($nintendo);
        */

        // Sauvegarder dans la base de données
        $manager->flush();
    }
}
