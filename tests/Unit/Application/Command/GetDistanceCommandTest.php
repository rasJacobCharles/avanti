<?php

declare(strict_types=1);


namespace App\Tests\Unit\Application\Command;

use App\Application\Command\GetDistanceCommand;
use App\Domain\ValueObject\Location;
use PHPUnit\Framework\TestCase;

class GetDistanceCommandTest extends TestCase
{
    public function testSuccessGetLocation(): void
    {
        $this->assertEquals(
            Location::create('51.507351', '-0.127758'),
            (new GetDistanceCommand('51.507351', '-0.127758'))->location
        );
    }
}
