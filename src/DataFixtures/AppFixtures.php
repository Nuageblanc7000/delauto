<?php

namespace App\DataFixtures;

use DateInterval;
use Faker\Factory;
use App\Entity\Car;
use App\Entity\Mark;
use App\Entity\Image;
use Cocur\Slugify\Slugify;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;



class AppFixtures extends Fixture
{
    /**
     * function permettant la création d'une date aléatoire
     *
     * @return DateTime
     */
    public function dateRand()
    {
     $dateLast = strtotime('1998-07-12');  
     $dateNew = strtotime('2021-12-12');
     $randomDate = rand($dateLast,$dateNew);
     $finalDate = date('d-m-Y',$randomDate);
     return  new \DateTime($finalDate);
    }

    /**
     * création des fixtures
     *
     * @param ObjectManager $manager (ancienne méthode maintenant managerEntityInterface)
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $slugify= new Slugify();
        // creation des différents tableaux.

        $carburant = ['diesel','essence'];
        $tranmission = ['automatique','manuel'];
        
        $markFaker = [
            1 => 'opel',
            2 => 'vw',
            3 => 'ford',
            4 => 'alfa-romeo',
            5 => 'bmw',
            6 => 'mercedes',
            7 => 'porsche',
            8 => 'jaguar',
            9 => 'renault',
            10 => 'peugeot'
        ];
        $modelFaker = [
            1 => 'insignia',
            2 => 'arteon',
            3 => 'gt-500',
            4 => 'giulia-super',
            5 => 'm-2-competition',
            6 => 'cls-200',
            7 => 'panamera',
            8 => 'xf-v8',
            9 => 'arkana',
            10 => '508'
        ];
        $coverFaker = [
            1 => 'http://www.wetterene-remy-dev.com/picture/cars/insignia.JPG',
            2 => 'http://www.wetterene-remy-dev.com/picture/cars/arteon.jpg',
            3 => 'http://www.wetterene-remy-dev.com/picture/cars/gt-500.jpg',
            4 => 'http://www.wetterene-remy-dev.com/picture/cars/giulia-super.jpg',
            5 => 'http://www.wetterene-remy-dev.com/picture/cars/m-2-competition.jpg',
            6 => 'http://www.wetterene-remy-dev.com/picture/cars/cls-200.jpg',
            7 => 'http://www.wetterene-remy-dev.com/picture/cars/panamera.jpg',
            8 => 'http://www.wetterene-remy-dev.com/picture/cars/xf-v8.jpg',
            9 => 'http://www.wetterene-remy-dev.com/picture/cars/arkana.jpg',
            10 => 'http://www.wetterene-remy-dev.com/picture/cars/508.jpg'
        ];

        

        for($i = 1; $i<= 10; $i++){
            $car = new Car();
            $mark = new Mark();
                $mark ->setNameMark($markFaker[$i]);  
                $manager->persist($mark);
                $carOptions = 'gps,climatisation';
                $description =$faker->paragraph();
            $car ->setModel($modelFaker[$i])
                 ->setCoverImage($coverFaker[$i])
                 ->setMark($mark)
                 ->setNumberOwners(rand(0,5))
                 ->setOptions($carOptions)
                 ->setPowerEngine(rand(90,400))
                 ->setEnginesize(rand(900,2800))
                 ->setDescription($description)
                 ->setFuel($carburant[rand(0,1)])
                 ->setKm(rand(0,200000))
                 ->setPrice(rand(1000,30000))
                 ->setTransmission($tranmission[rand(0,1)])
                 ->setSlug($slugify->slugify($car->getModel()).uniqid())
                 ->setYearOfEntry($this->dateRand());
                 
                 $manager->persist($car);

                 for($z = 0; $z<=3; $z++){
                 $imageCar = new Image();
                 $imageCar ->setNameImg("https://picsum.photos/id/".rand(220,233)."/800/1200")
                           ->setCaption('image aléatoire')
                           ->setCar($car);

            $manager->persist($imageCar);
          }
                 
        }


        $manager->flush();
    }
}
