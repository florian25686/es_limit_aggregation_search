<?php

namespace App\Services;

use Elastica\Client;

class ElasticClientService
{
    public function getElasticClient(): Client
    {
        return new Client(
            [
                'host' => 'es01',
                'port' => 9200,
                'transport' => 'https',
                'username' => 'elastic',
                'password' => 'random_password',
                // Current Setup doesn't like self-signed certificates
                'curl' => [
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false,
                ]
            ]
        );
    }
}