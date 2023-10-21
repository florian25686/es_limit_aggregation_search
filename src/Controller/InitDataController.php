<?php

namespace App\Controller;

use Elastica\Client;
use Elastica\Document;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InitDataController
{
    private Client $elasticaClient;

    public function __construct(
    ) {
        $this->elasticaClient = new Client(
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

    #[Route('/setup/index', methods: ['GET'])]
    public function setupIndex(): Response
    {
        $elasticaIndex = $this->elasticaClient->getIndex('books');
        $elasticaIndex->addDocuments($this->getExampleDocuments());

        return new Response(
            'Example documents created',
            \Symfony\Component\HttpFoundation\Response::HTTP_OK
        );
    }

    private function getExampleDocuments(): array
    {
        return [
            new Document(
                '1',
                [
                    "title" => "The Catcher in the Rye",
                    "author" => "J.D. Salinger",
                    "description" => "A classic novel about the struggles of a young man in New York City.",
                    "genre" => "Fiction",
                    "published_year" => 1951
                ]
            ),
            new Document(
                '2',
                [
                    "title" => "To Kill a Mockingbird",
                    "author" => "Harper Lee",
                    "description" => "A story of racial injustice and moral growth in the American South.",
                    "genre" => "Fiction",
                    "published_year" => 1960
                ]
            ),
            new Document(
                '3',
                [
                    "title" => "1984",
                    "author" => "George Orwell",
                    "description" => "A dystopian novel set in a totalitarian society where free thought is forbidden.",
                    "genre" => "Science Fiction",
                    "published_year" => 1949
                ]
            ),
            new Document(
                '4',
                [
                    "title" => "The Great Gatsby",
                    "author" => "F. Scott Fitzgerald",
                    "description" => "A tale of wealth, love, and tragedy in the Roaring Twenties.",
                    "genre" => "Fiction",
                    "published_year" => 1925
                ]
            ),
            new Document(
                '5',
                [
                    "title" => "Pride and Prejudice",
                    "author" => "Jane Austen",
                    "description" => "A story of love, class, and societal expectations in 19th-century England.",
                    "genre" => "Romance",
                    "published_year" => 1813
                ]
            ),
            new Document(
                '6',
                [
                    "title" => "The Hobbit",
                    "author" => "J.R.R. Tolkien",
                    "description" => "An adventure in a fantastical world, where a hobbit sets out on a quest.",
                    "genre" => "Science",
                    "published_year" => 1937
                ]
            ),
            new Document(
                '7',
                [
                    "title" => "The Martian",
                    "author" => "Andy Weir",
                    "description" => "A story of an astronaut stranded on Mars and his fight for survival.",
                    "genre" => "Science Fiction",
                    "published_year" => 2011
                ]
            ),
            new Document(
                '8',
                [
                    "title" => "Harry Potter and the Philosopher's Stone",
                    "author" => "J.K. Rowling",
                    "description" => "The first book in the famous Harry Potter series, introducing the young wizard.",
                    "genre" => "Fantasy",
                    "published_year" => 1997
                ]
            ),
            new Document(
                '9',
                [
                    "title" => "The Road",
                    "author" => "Cormac McCarthy",
                    "description" => "A post-apocalyptic tale of a father and son's journey through a desolate world.",
                    "genre" => "Fantasy Novel",
                    "published_year" => 2006
                ]
            ),
            new Document(
                '10',
                [
                    "title" => "The Da Vinci Code",
                    "author" => "Dan Brown",
                    "description" => "A thrilling mystery involving art, history, and religion.",
                    "genre" => "Thriller",
                    "published_year" => 2003
                ]
            ),
            new Document(
                '11',
                [
                    "title" => "The Da Vinci Code second take",
                    "author" => "Dan Brown",
                    "description" => "A thrilling mystery involving art, history, and religion.",
                    "genre" => "Novel",
                    "published_year" => 2003
                ]
            )
        ];
    }
}