<?php

namespace App\Controller;

use App\Entity\Location;
use App\Repository\LocationRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/location-dummy')]
final class LocationController extends AbstractController
{
    #[Route('/create')]
    public function create(LocationRepository $locationRepository): JsonResponse
    {
        $location = new Location();
        $location
            ->setName('Gandia')
            ->setCountryCode('es')
            ->setLatitude(38.15689)
            ->setLongitude(-0.15456)
        ;

        $locationRepository->save($location, true);

        return new JsonResponse([
            'id' => $location->getId()
        ]);
    }

    #[Route('/edit')]
    public function edit(LocationRepository $locationRepository): JsonResponse
    {

        $location = $locationRepository->find(9);
        $location->setName("Grau de Gandia");
        $locationRepository->save($location, true);

        return new JsonResponse([
            'id' => $location->getId(),
            'name' => $location->getName()
        ]);
    }

    #[Route('/remove/{id<\d+>?}')]
    public function remove(LocationRepository $locationRepository, int $id, ): JsonResponse
    {

        $location = $locationRepository->find($id);

        if (!$location) {
            throw $this->createNotFoundException();
        }

        $locationRepository->remove($location, true);

        return new JsonResponse(null);

    }

    #[Route(path: '/show/{location_name}')]
    public function show(
        #[MapEntity(mapping: ['location_name' => 'name'])]
        Location $location,
    ): JsonResponse {

        $json = [
            'id' => $location->getId(),
            'name' => $location->getName(),
            'country' => $location->getCountryCode(),
            'lat' => $location->getLatitude(),
            'long' => $location->getLongitude(),
        ];

        foreach ($location->getForecasts() as $forecast) {
            $json['forecasts'][$forecast->getDate()->format('Y-m-d')] = [
                'celsius' => $forecast->getCelsius()
            ];
        }
        return new JsonResponse($json);
    }

    #[Route('/')]
    public function index(LocationRepository $locationRepository): JsonResponse
    {
        $locations = $locationRepository->findAllWithForecats();
        $json = [];

        foreach ($locations as $location) {

            $locationJson = [
                'id' => $location->getId(),
                'name' => $location->getName(),
                'country' => $location->getCountryCode(),
                'lat' => $location->getLatitude(),
                'long' => $location->getLongitude(),
            ];

            foreach ($location->getForecasts() as $forecast) {
                $locationJson['forecasts'][$forecast->getDate()->format('Y-m-d')] = [
                    'celsius' => $forecast->getCelsius()
                ];
            }

            $json[] = $locationJson;
        }

        return new JsonResponse($json);
    }
}
