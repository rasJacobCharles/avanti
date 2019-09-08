<?php

namespace App\Tests\Unit\Application\Command;

use App\Application\Command\GetIssLocationHandler;
use App\Domain\ValueObject\Location;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class GetIssLocationHandlerTest extends TestCase
{
    private $response = <<<JSON
{
    "name": "iss",
    "id": 25544,
    "latitude": -12.387535216929,
    "longitude": 66.023929042747,
    "altitude": 414.06814503409,
    "velocity": 27596.348699192,
    "visibility": "eclipsed",
    "footprint": 4477.1608776427,
    "timestamp": 1567959295,
    "daynum": 2458735.1770255,
    "solar_lat": 5.6229963502875,
    "solar_lon": 295.70323021387,
    "units": "kilometers"
}
JSON;


    public function testSuccessGetLocation(): void
    {
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockHttpClient = $this->createMock(HttpClientInterface::class);
        $expectLocation = Location::create('-12.387535216929',  '66.023929042747', '414.06814503409');

        $mockResponse
            ->expects($this->once())
            ->method('getStatusCode')
            ->willReturn(200);

        $mockResponse
            ->expects($this->once())
            ->method('getContent')
            ->willReturn($this->response);

        $mockHttpClient
            ->expects($this->once())
            ->method('request')
            ->with('GET', 'https://api.wheretheiss.at/v1/satellites/25544')
            ->willReturn($mockResponse);

        $service = new GetIssLocationHandler($mockHttpClient);
        $this->assertInstanceOf(Location::class, $result = $service());
        $this->assertEquals($expectLocation, $result);
    }
}
