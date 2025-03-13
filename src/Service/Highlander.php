<?php

declare(strict_types=1);

namespace App\Service;



use App\Model\HighlanderApiDTO;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Highlander
{

    public function __construct(
        private ValidatorInterface $validator,
    )
    {
    }


    public function say(int $treshold = 50, int $trials = 1): array
    { $dto = new HighlanderApiDTO();
        $dto->treshold = $treshold;
        $dto->trials = $trials;

        $errors =   $this->validator->validate($dto);

        if (count($errors) > 0) {
            throw new \Exception((string)$errors);
        }



        $forecasts = [];
        for ($i = 0; $i < $trials; $i++) {
            $draw = random_int(0, 100);
            $forecast = $draw < $treshold ? "It's going to rain" : "It's going to sunny";
            $forecasts[] = $forecast;
        }

        return $forecasts;
    }
}