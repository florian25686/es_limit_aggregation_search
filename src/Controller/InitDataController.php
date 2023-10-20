<?php

namespace App\Controller;

use Elastica\Client;
use Elastica\Response;
use Symfony\Component\Routing\Annotation\Route;

class InitDataController
{
    private Client $elasticaClient;

    public function __construct(
    ) {
        $this->elasticaClient = new Client(
            [
                'host' => 'elastic_demo-es01-1',
                'port' => 9200,
                'password' => 'random_password!@',
            ]
        );
    }

    #[Route('setup/index', methods: ['GET'])]
    public function setupIndex(): Response
    {
        $elasticaIndex = $this->elasticaClient->getIndex('twitter');
// Create the index new
        $elasticaIndex->create(
            array(
                'number_of_shards' => 4,
                'number_of_replicas' => 1,
                'analysis' => array(
                    'analyzer' => array(
                        'default_index' => array(
                            'type' => 'custom',
                            'tokenizer' => 'standard',
                            'filter' => array('lowercase', 'mySnowball')
                        ),
                        'default_search' => array(
                            'type' => 'custom',
                            'tokenizer' => 'standard',
                            'filter' => array('standard', 'lowercase', 'mySnowball')
                        )
                    ),
                    'filter' => array(
                        'mySnowball' => array(
                            'type' => 'snowball',
                            'language' => 'German'
                        )
                    )
                )
            ),
            true
        );

        return new Response(
            '',
            \Symfony\Component\HttpFoundation\Response::HTTP_OK
        );
    }
}