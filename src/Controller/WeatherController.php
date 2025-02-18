<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController
{
    #[Route('/weather/highlander-says')]
    public function highlanderSays(): Response
    {
        $draw = random_int(0, 100);
        $forecast  = $draw < 50 ? "rain" : "sunny";

        return new Response(
            "<html><body>$forecast $draw</body></html>"
        );
    }
}
