<?php

declare(strict_types=1);


namespace App\Tests\Unit\Application\Command;

use App\Application\Command\GetDistanceCommand;
use App\Application\Command\GetDistanceHandler;
use App\Application\Command\GetIssLocationHandler;
use App\Domain\ValueObject\Location;
use PHPUnit\Framework\TestCase;

class GetDistanceHandlerTest extends TestCase
{
    public function testSuccessGetDistance(): void
    {
        $mockHandler = $this->createMock(GetIssLocationHandler::class);

        $mockHandler
            ->expects($this->once())
            ->method('__invoke')
            ->willReturn(Location::create('50.11496269845',  '118.07900427317'));

        $service = new GetDistanceHandler($mockHandler);
        $this->assertEquals(
            [
                'iss' => [50.11496269845, 118.07900427317],
                'location' => [51.507351, -0.127758],
                'distance' => 7302.57
            ],
            $service(new GetDistanceCommand('51.507351', '-0.127758'))
        );

    }
}
