<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\HighlanderApiDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;

use Symfony\Contracts\Translation\TranslatorInterface as TranslationTranslatorInterface;

// #[Route('/weather')]
class WeatherController extends AbstractController
{

    // #[Route('/highlander-says/api')]
    public function highlanderSaysApi(
        #[MapQueryString] ?HighlanderApiDTO $dto = null,
    ): JsonResponse {

        if (!$dto) {
            $dto = new HighlanderApiDTO();
            $dto->treshold = 50;
            $dto->trials = 1;
        }

        $forecasts = [];
        for ($i = 0; $i < $dto->trials; $i++) {
            $draw = random_int(0, 100);
            $forecast = $draw < $dto->treshold ? "rain" : "sunny";
            $forecasts[] = $forecast;
        }
        $json = [
            'forecasts' => $forecasts,
            'treshold' => $dto->treshold,
        ];
        //return new JsonResponse($json);
        return $this->json($json, Response::HTTP_OK);
    }

    // #[Route('/highlander-says/{treshold<\d+>}')]
    public function highlanderSays(
        Request $request,
        RequestStack $requestStack,
        TranslationTranslatorInterface $translator,
        ?int $treshold = null,
        #[MapQueryParameter] ?string $_format = 'html'
    ): Response {

        $session = $requestStack->getSession();

        if ($treshold) {
            $session->set('treshold', $treshold);
            $this->addFlash(
                "info",
                $translator->trans('weather.highlander_says.success', [
                    '%treshold%' => $treshold
                ])
            );
        } else {
            $treshold = $session->get('treshold', 50);
        }


        $trials = $request->get('trials', 1);

        $forecasts = [];

        for ($i = 0; $i < $trials; $i++) {
            $draw = random_int(0, 100);
            $forecast = $draw < $treshold ? "It's goint to rain" : "It's goint to be sunny";
            $forecasts[] = $forecast;
        }

        $html = $this->renderView("weather/highlander_says.{$_format}.twig", compact('forecasts', 'treshold'));
        $response = new Response($html);
        return $response;
    }

    // #[Route('/highlander-says/{guess}')]
    public function highlanderSaysGuess(string $guess): Response
    {
        $availableGuesses = ['snow', 'rain', 'hail'];

        if (!in_array($guess, $availableGuesses)) {
            throw $this->createNotFoundException('This guess is not found.'); //404
            // throw new NotFoundHttpException('This guess is not found.(manually)'); //404
            // throw new BadRequestHttpException('Bad Request'); //400
            // throw new \Exception('Base Exception'); //500
        }
        $forecast = "It's going to $guess";
        $forecasts = [$forecast];
        return $this->render('weather/highlander_says.html.twig', compact('forecasts'));
    }

    // #[Route('/test', name: 'customtest')]
    public function test(): Response
    {
        $forecast = "TEST";
        return $this->render('weather/highlander_says.html.twig', compact('forecast'));
    }
}
