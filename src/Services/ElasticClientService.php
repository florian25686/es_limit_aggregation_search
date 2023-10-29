<?php

namespace App\Services;

use Elastica\Client;

class ElasticClientService
{
    public function __construct(
        private readonly string $elasticUsername,
        private readonly string $elasticPassword,
    )
    {
    }

    public function getElasticClient(): Client
    {
        return new Client(
            [
                'host' => 'es01',
                'port' => 9200,
                'transport' => 'https',
                'username' => $this->elasticUsername,
                'password' => $this->elasticPassword, // random_password
                // Current Setup doesn't like self-signed certificates
                'curl' => [
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false,
                ]
            ]
        );
    }
}