<?php

declare(strict_types=1);

namespace Tests\Functional\UI\Http\Rest\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IssRestControllerTest extends WebTestCase
{
    public function testSuccessGetIssLocation(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/v1/iss/location');
        $response = $client->getResponse();

        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertContains("iss", $response->getContent());
    }

    public function testSuccessGetDistanceBetweenLondonAndIds(): void
    {
        $client = static::createClient();
        $client->request('POST', '/api/v1/iss/distance', ['latitude' => 51.507351 ,'longitude' => -0.127758]);

        $response = $client->getResponse();
        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertContains('distance', $response->getContent());
    }

    /**
     * @dataProvider invalidLocationDataProvider
     */
    public function testFailureBadRequestGetDistanceBetweenLondonAndIds(array $option): void
    {
        $client = static::createClient();
        $client->request('POST', '/api/v1/iss/distance', $option);

        $response = $client->getResponse();
        $this->assertEquals($response->getStatusCode(), 400);
    }

    public function invalidLocationDataProvider(): array
    {
        return
        [
            [['latitude' => '' ,'longitude' => '-0.127758']],
            [['latitude' => '0.127758' ,'longitude' => '']]
        ];
    }
}