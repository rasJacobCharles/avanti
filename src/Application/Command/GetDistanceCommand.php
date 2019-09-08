<?php

declare(strict_types=1);


namespace App\Application\Command;


use App\Domain\ValueObject\Location;

class GetDistanceCommand
{
    /**
     * @var Location
     */
    public $location;

    public function __construct(string $latitude, string $longitude)
    {
        $this->location = Location::create($latitude, $longitude);
    }
}