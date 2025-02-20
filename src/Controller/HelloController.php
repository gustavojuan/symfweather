<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HelloController
{

    #[Route('/hello')]
    public function __invoke(): Response
    {
        return new Response('Hello');
    }
}
