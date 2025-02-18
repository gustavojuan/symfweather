<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{


    #[Route('/weather/highlander-says')]
    public function highlanderSays(): Response
    {
        $draw = random_int(0, 100);
        $forecast  = $draw < 50 ? "rain" : "sunny";

        return $this->render('weather/hihlander_says.html.twig', compact('forecast'));
    }
}
