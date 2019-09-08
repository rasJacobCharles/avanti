<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Controller;

use App\Application\Command\GetDistanceCommand;
use App\Application\Command\GetDistanceHandler;
use App\Application\Command\GetIssLocationHandler;
use Assert\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @Route("/api/v1/iss")
 */
class IssController extends AbstractController
{
    /**
     * @var HttpClientInterface
     */
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @Route("/location", name="location", methods={"GET"})
     */
    public function location(): Response
    {
        $handler = new GetIssLocationHandler($this->client);
        $location = $handler();

        return new JsonResponse(
            [
                'iss' => [
                    'latitude' => $location->latitude,
                    'longitude' => $location->longitude,
                    'altitude' => $location->altitude
                ]
            ]
            );
    }

    /**
     * @Route("/distance", name="distance", methods={"POST"})
     */
    public function distance(Request $request): Response
    {
        $handler = new GetDistanceHandler(new GetIssLocationHandler($this->client));
        try{
            $command = new GetDistanceCommand(
                (string) $request->request->get('latitude') ?? $request->get('latitude'),
                (string) $request->request->get('longitude') ?? $request->get('longitude')
            );

        } catch (InvalidArgumentException $exception) {
            return new Response( $exception->getMessage(), 400);
        }

        return new JsonResponse($handler($command));
    }
}