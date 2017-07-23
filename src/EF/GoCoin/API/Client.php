<?php

namespace EF\GoCoin\API;

use GuzzleHttp\Client as Guzzle;

class Client
{
    private $guzzle = null;

    public function __construct(string $apiUrl, string $apiKey, Guzzle $guzzle = null)
    {
        if (null === $guzzle) {
            $guzzle = new Guzzle([
                'base_uri' => $apiUrl,
                'headers'  => [
                    'Authorization' => 'Bearer '.$apiKey,
                    'Content-Type'  => 'application/json',
                ],
            ]);
        }

        $this->guzzle = $guzzle;
    }

    public function getGuzzle()
    {
        return $this->guzzle;
    }

    private function runAction(string $httpMethod, string $endpoint) : array
    {
        $data     = [];
        $response = $this->guzzle->request($httpMethod, $endpoint);
        $data     = (string)$response->getBody();
        $data     = json_decode($data, true);

        return $data;
    }

    public function getUser()
    {
        return $this->runAction('GET', 'user');
    }
}
