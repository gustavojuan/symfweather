<?php

namespace App\DataFixtures;

use App\Entity\Forecast;
use App\Entity\Location;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {


        $location = $this->addLocation('Barcelona', 'ES', 41.33879, 2.15899);
        $manager->persist($location);

        $forecast = $this->addForecast($location, '2024-01-01', 25);
        $manager->persist($forecast);
        $forecast = $this->addForecast($location, '2024-01-02', 28);
        $manager->persist($forecast);
        $forecast = $this->addForecast($location, '2024-01-03', 29);
        $manager->persist($forecast);
        $forecast = $this->addForecast($location, '2024-01-04', 30);
        $manager->persist($forecast);

        $location = $this->addLocation('Madrid', 'ES', 40.41678, -3.70379);
        $manager->persist($location);

        $location = $this->addLocation('Valencia', 'ES', 39.46991, -0.37629);
        $manager->persist($location);

        $location = $this->addLocation('Sevilla', 'ES', 37.38863, -5.98233);
        $manager->persist($location);

        $location = $this->addLocation('Bilbao', 'ES', 43.26301, -2.93499);
        $manager->persist($location);

        $location = $this->addLocation('Málaga', 'ES', 36.72127, -4.42140);
        $manager->persist($location);
        $manager->flush();
    }


    private function addLocation(string $name, string $code, float $latitude, float $longitude): Location
    {
        $location = new Location();
        $location->setName($name)
            ->setCountryCode($code)
            ->setLatitude($latitude)
            ->setLongitude($longitude);

        return $location;
    }

    private function addForecast(Location $location, string $dateString, int $celsius): Forecast
    {
        $forecast = new Forecast();
        $forecast->setLocation($location)
            ->setDate(new \DateTime($dateString))
            ->setCelsius($celsius);


        return $forecast;
    }
}
