<?php

declare(strict_types=1);


namespace App\Tests\Unit\Domain\ValueObject;

use App\Domain\ValueObject\Location;
use PHPUnit\Framework\TestCase;

class LocationTest extends TestCase
{
    public function testSuccessCreateLocation(): void
    {
        $result = Location::create('50.11496269845',  '118.07900427317');

        $this->assertInstanceOf(Location::class, $result);
        $this->assertEquals(50.11496269845, $result->latitude);
        $this->assertEquals(118.07900427317, $result->longitude);
        $this->assertEquals(0, $result->altitude);
    }

    public function testSuccessCreateLocationWithAltitude(): void
    {
        $result = Location::create('50.11496269845',  '118.07900427317', 408.05526028199);

        $this->assertInstanceOf(Location::class, $result);
        $this->assertEquals(50.11496269845, $result->latitude);
        $this->assertEquals(118.07900427317, $result->longitude);
        $this->assertEquals(408.05526028199, $result->altitude);
    }
}
