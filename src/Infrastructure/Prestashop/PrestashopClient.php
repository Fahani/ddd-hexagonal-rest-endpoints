<?php

declare(strict_types=1);

namespace App\Infrastructure\Prestashop;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;

class PrestashopClient
{
    private Client $client;
    private string $endpoint;

    public function __construct(Client $client, string $endpoint)
    {
        $this->client = $client;
        $this->endpoint = $endpoint;
    }

    /**
     * @return array
     * @throws GuzzleException
     * @throws JsonException
     */
    public function executeOperation(): array
    {
        $response = $this->client->request('get', $this->endpoint)->getBody()->getContents();
        return json_decode($response, true, 512, JSON_THROW_ON_ERROR);
    }
}