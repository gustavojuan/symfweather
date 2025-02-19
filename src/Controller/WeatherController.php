<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[Route('/weather')]
class WeatherController extends AbstractController
{

    #[Route('/highlander-says/{treshold<\d+>?50}', host: 'api.localhost')]
    public function highlanderSaysApi(int $treshold): JsonResponse
    {
        $draw = random_int(0, 100);
        $forecast  = $draw < $treshold ? "rain" : "sunny";

        $json  = [
            'forecast' => $forecast,
            'treshold' => $treshold,
            'self' => $this->generateUrl(
                'app_weather_highlandersaysapi',
                compact('treshold'),
                UrlGeneratorInterface::ABSOLUTE_URL
            )
        ];
        return new JsonResponse($json);
    }

    // #[Route('/highlander-says/{treshold<\d+>?50}')]
    public function highlanderSays(int $treshold): Response
    {
        $draw = random_int(0, 100);
        $forecast  = $draw < $treshold ? "rain" : "sunny";

        return $this->render('weather/highlander_says.html.twig', compact('forecast'));
    }

    // #[Route('/highlander-says/{guess}')]
    public function highlanderSaysGuess(string $guess): Response
    {
        $forecast  = "It's going to $guess";
        return $this->render('weather/highlander_says.html.twig', compact('forecast'));
    }

    // #[Route('/test', name: 'customtest')]
    public function test(): Response
    {
        $forecast  = "TEST";
        return $this->render('weather/highlander_says.html.twig', compact('forecast'));
    }
}
