<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{

    // #[Route('/weather/highlander-says/{treshold<\d+>?50}')]
    public function highlanderSays(int $treshold): Response
    {
        $draw = random_int(0, 100);
        $forecast  = $draw < $treshold ? "rain" : "sunny";

        return $this->render('weather/highlander_says.html.twig', compact('forecast'));
    }

    //#[Route('/weather/highlander-says/{guess}')]
    public function highlanderSaysGuess(string $guess): Response
    {
        $forecast  = "It's going to $guess";
        return $this->render('weather/highlander_says.html.twig', compact('forecast'));
    }
}
