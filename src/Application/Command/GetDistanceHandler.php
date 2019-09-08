<?php

declare(strict_types=1);


namespace App\Application\Command;

use App\Domain\ValueObject\Location;

class GetDistanceHandler
{
    private const METERS = 6371e3;

    /**
     * @var GetIssLocationHandler
     */
    private $handler;

    public function __construct(GetIssLocationHandler $handler)
    {
        $this->handler = $handler;
    }

    public function __invoke(GetDistanceCommand $command): array
    {
        $service = $this->handler;
        $issLocation = $service();

        return
            [
                'iss' => [$issLocation->latitude, $issLocation->longitude],
                'location' => [$command->location->latitude, $command->location->longitude],
                'distance' => round($this->getDistance($issLocation, $command->location) / 1000, 2)
            ];
    }

    private function getDistance(Location $locationX, Location $locationY): float
    {
        $latitude1  = deg2rad($locationX->latitude);
        $latitude2 = deg2rad($locationY->latitude);
        $longitudeDiff = deg2rad($locationY->longitude - $locationX->longitude);
        $latitudeDiff = deg2rad($locationY->latitude - $locationX->latitude);

        $a  = sin($latitudeDiff/2) * sin($latitudeDiff/2) +
             cos($latitude1) *  cos($latitude2) *
            sin($longitudeDiff/2) * sin($longitudeDiff/2);

        $c = 2 * atan2(sqrt($a), sqrt(1-$a));

        return self::METERS * $c;
    }
}