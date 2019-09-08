<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\ValueObject\Location;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GetIssLocationHandler
{
    private const LOCATION_URL = 'https://api.wheretheiss.at/v1/satellites/25544';

    /**
     * @var HttpClientInterface
     */
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function __invoke():Location
    {
        $response = $this->client->request('GET', self::LOCATION_URL);
        if ($response->getStatusCode() === Response::HTTP_OK) {

            $content = json_decode($response->getContent());

            return Location::create((string) $content->latitude, (string) $content->longitude, $content->altitude);

        }
    }
}