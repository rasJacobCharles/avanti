<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use Assert\Assertion;

class Location
{
    public $latitude;
    public $longitude;
    public $altitude;

    private function __construct(float $latitude, float $longitude, float $altitude)
    {

        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->altitude = $altitude;
    }

    public static function create(string $latitude, string $longitude, float $altitude = 0)
    {
        Assertion::notEmpty($latitude, 'Invalid latitude');
        Assertion::notEmpty($longitude, 'Invalid longitude');

        return new self((float)$latitude, (float)$longitude, $altitude);
    }
}