<?php

namespace App\Controller;

use App\Entity\Location;
use App\Repository\LocationRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
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
            return new JsonResponse('Not Found');
        }

        $locationRepository->remove($location, true);

        return new JsonResponse(null);

    }

    #[Route(path: '/show/{name}')]
    public function show(
        LocationRepository $locationRepository,
        string $name,
    ): JsonResponse {


        //magic method
        //$location = $locationRepository->findByNameAndCountryCode($name,$country);
        $location = $locationRepository->findOneByName($name);

        $json = [
            'id' => $location->getId(),
            'name' => $location->getName(),
            'country' => $location->getCountryCode(),
            'lat' => $location->getLatitude(),
            'long' => $location->getLongitude(),
        ];


        return new JsonResponse($json);

    }

    #[Route('/')]
    public function index(LocationRepository $locationRepository): JsonResponse
    {

        $locations = $locationRepository->findAll();
        $json = [];
        foreach ($locations as $location) {
            $json[] = [
                'id' => $location->getId(),
                'name' => $location->getName(),
                'country' => $location->getCountryCode(),
                'lat' => $location->getLatitude(),
                'long' => $location->getLongitude(),
            ];
        }

        return new JsonResponse($json);
    }
}
