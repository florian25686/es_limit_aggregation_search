<?php

namespace App\Api;

use App\Services\ElasticClientService;
use Elastica\Query;
use Elastica\Aggregation;
use Elastica\ResultSet;
use Elastica\Util;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_')]
class SearchController
{
    public function __construct(
        private readonly ElasticClientService $elasticClientService,
    )
    {
    }

    #[Route('/search', name: 'search', methods: ['POST'])]
    public function searchBooks(Request $request): JsonResponse
    {
        $searchString = $request->get('searchstring', null);
        $elasticResult = $this->executeSearchOnIndex('books', $searchString);

        $aggregations = $elasticResult->getAggregations()['genre'];
        $result = [];

        $minimumScore = 0;
        foreach ($aggregations['buckets'] as $index => $bucket) {
            $avgScoring = $bucket['scoring']['avg'];
            $neededMinScore = ($avgScoring * 0.9);
            if ($neededMinScore > $minimumScore || $minimumScore === 0) {
                $minimumScore = $neededMinScore;
            }
            if ($avgScoring < $minimumScore) {
                continue;
            }

            $result[] = [
                'id' => $index,
                'label' => $bucket['key'],
            ];
        }

        return new JsonResponse(
            $result,
            Response::HTTP_OK
        );
    }

    private function executeSearchOnIndex(string $indexName, string $searchString): ResultSet
    {
        $elasticIndex = $this->elasticClientService->getElasticClient()
            ->getIndex($indexName);

        $preparedSearchString = $this->prepareSearchStringWithWildcards($searchString);
        $result = $elasticIndex->search(
            (new Query(
                (new Query\BoolQuery(
                    )
                )->addMust(
                    (new Query\QueryString($preparedSearchString))->setFields(['genre'])
                )
                )
            )->addAggregation(
                    agg: (new Aggregation\Terms('genre'))
                ->setField('genre.keyword')
                ->setMinimumDocumentCount(1)
                ->setOrder('scoring.max', 'desc')
                ->addAggregation(
                    (new Aggregation\Stats('scoring'))
                    ->setScript('_score')
                )
            )
        );

        return $result;
    }

    private function prepareSearchStringWithWildcards(string $searchString): string
    {
       $searchString = Util::escapeTerm($searchString);
       $searchStringWithWildcards = preg_replace('/\s+/', '* ', $searchString);
       $searchStringWithWildcards .= '*';

        return $searchStringWithWildcards;
    }
}