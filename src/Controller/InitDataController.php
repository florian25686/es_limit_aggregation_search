<?php

namespace App\Controller;

use App\Services\ElasticClientService;
use Elastica\Document;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InitDataController
{
    private const FICTION_GENRE = 'Fiction';
    const SCIENCE_FICTION_GENRE = 'Science Fiction';
    const NOVEL_GENRE = 'Novel';
    const FANTASY_GENRE = 'Fantasy';
    const SCIENCE_GENRE = 'Science';
    const ROMANCE_GENRE = 'Romance';
    const FANTASY_NOVEL = 'Fantasy Novel';

    public function __construct(
        private readonly ElasticClientService $elasticClientService,
    ) {
    }

    #[Route('/setup/index', name: 'setup_index', methods: ['GET'])]
    public function setupIndex(): Response
    {
        $elasticaIndex = $this->elasticClientService->getElasticClient()->getIndex('books');
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
                    'title' => 'The Catcher in the Rye',
                    'author' => 'J.D. Salinger',
                    'description' => 'A classic novel about the struggles of a young man in New York City.',
                    'genre' => self::FICTION_GENRE,
                    'published_year' => 1951
                ]
            ),
            new Document(
                '2',
                [
                    'title' => 'To Kill a Mockingbird',
                    'author' => 'Harper Lee',
                    'description' => 'A story of racial injustice and moral growth in the American South.',
                    'genre' => self::FICTION_GENRE,
                    'published_year' => 1960
                ]
            ),
            new Document(
                '3',
                [
                    'title' => '1984',
                    'author' => 'George Orwell',
                    'description' => 'A dystopian novel set in a totalitarian society where free thought is forbidden.',
                    'genre' => self::SCIENCE_FICTION_GENRE,
                    'published_year' => 1949
                ]
            ),
            new Document(
                '4',
                [
                    'title' => 'The Great Gatsby',
                    'author' => 'F. Scott Fitzgerald',
                    'description' => 'A tale of wealth, love, and tragedy in the Roaring Twenties.',
                    'genre' => self::FICTION_GENRE,
                    'published_year' => 1925
                ]
            ),
            new Document(
                '5',
                [
                    'title' => 'Pride and Prejudice',
                    'author' => 'Jane Austen',
                    'description' => 'A story of love, class, and societal expectations in 19th-century England.',
                    'genre' => self::ROMANCE_GENRE,
                    'published_year' => 1813
                ]
            ),
            new Document(
                '6',
                [
                    'title' => 'The Hobbit',
                    'author' => 'J.R.R. Tolkien',
                    'description' => 'An adventure in a fantastical world, where a hobbit sets out on a quest.',
                    'genre' => self::SCIENCE_GENRE,
                    'published_year' => 1937
                ]
            ),
            new Document(
                '7',
                [
                    'title' => 'The Martian',
                    'author' => 'Andy Weir',
                    'description' => 'A story of an astronaut stranded on Mars and his fight for survival.',
                    'genre' => self::SCIENCE_FICTION_GENRE,
                    'published_year' => 2011
                ]
            ),
            new Document(
                '8',
                [
                    'title' => 'Harry Potter and the Philosopher\'s Stone',
                    'author' => 'J.K. Rowling',
                    'description' => 'The first book in the famous Harry Potter series, introducing the young wizard.',
                    'genre' => self::FANTASY_GENRE ,
                    'published_year' => 1997
                ]
            ),
            new Document(
                '9',
                [
                    'title' => 'The Road',
                    'author' => 'Cormac McCarthy',
                    'description' => 'A post-apocalyptic tale of a father and son\'s journey through a desolate world.',
                    'genre' => self::FANTASY_NOVEL,
                    'published_year' => 2006
                ]
            ),
            new Document(
                '10',
                [
                    'title' => 'The Da Vinci Code',
                    'author' => 'Dan Brown',
                    'description' => 'A thrilling mystery involving art, history, and religion.',
                    'genre' => self::FANTASY_GENRE,
                    'published_year' => 2003
                ]
            ),
            new Document(
                '11',
                [
                    'title' => 'The Da Vinci Code second take',
                    'author' => 'Dan Brown',
                    'description' => 'A thrilling mystery involving art, history, and religion.',
                    'genre' => self::NOVEL_GENRE,
                    'published_year' => 2003
                ]
            )
        ];
    }
}