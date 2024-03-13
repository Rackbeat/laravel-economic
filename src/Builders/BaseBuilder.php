<?php

namespace LasseRafn\Economic\Builders;

use Illuminate\Support\Facades\Log;
use LasseRafn\Economic\Utils\Model;
use LasseRafn\Economic\Utils\Request;
use LasseRafn\Economic\Services\QueryGeneratorService;

class BaseBuilder
{
    protected $request;
    protected $entity;

    /** @var Model */
    protected $model;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

	/**
	 * @param $id
	 *
	 * @return Model
	 * @throws \LasseRafn\Economic\Exceptions\EconomicClientException
	 * @throws \LasseRafn\Economic\Exceptions\EconomicRequestException
	 */
    public function find($id)
    {
        return $this->request->handleWithExceptions(function () use ($id) {
            $response = $this->request->doRequest('get', "{$this->rest_version}/{$this->entity}/{$id}");

			$responseData = json_decode($response->getBody()->getContents());

			$response->getBody()->close();

            return new $this->model($this->request, $responseData);
        });
    }


	/**
	 * @return null|Model
	 * @throws \LasseRafn\Economic\Exceptions\EconomicClientException
	 * @throws \LasseRafn\Economic\Exceptions\EconomicRequestException
	 */
	public function first($sortByField = null)
	{
		return $this->request->handleWithExceptions( function () use($sortByField) {
			$response = $this->request->doRequest('get', "{$this->rest_version}/{$this->entity}?skippages=0&pagesize=1&sort={$sortByField}");

			$fetchedItems = json_decode($response->getBody()->getContents())->collection;

			$response->getBody()->close();

			if ( count( $fetchedItems ) === 0 ) {
				return null;
			}

			return new $this->model( $this->request, $fetchedItems[0] );
		} );
	}

	/**
	 * @return null|Model
	 * @throws \LasseRafn\Economic\Exceptions\EconomicClientException
	 * @throws \LasseRafn\Economic\Exceptions\EconomicRequestException
	 */
    public function last($sortByField)
    {
        return $this->request->handleWithExceptions(function () use($sortByField) {
		$response = $this->request->doRequest('get', "{$this->rest_version}/{$this->entity}?skippages=0&pagesize=1&sort=-{$sortByField}");
	
		$fetchedItems = json_decode($response->getBody()->getContents())->collection;
	
		$response->getBody()->close();

            if (count($fetchedItems) === 0) {
				return null;
            }

            return new $this->model($this->request, $fetchedItems[0]);
        });
    }

	/**
	 * @param array $filters
	 *
	 * @return \Illuminate\Support\Collection|Model[]
	 * @throws \LasseRafn\Economic\Exceptions\EconomicClientException
	 * @throws \LasseRafn\Economic\Exceptions\EconomicRequestException
	 */
    public function get($filters = [], $sorting = [])
    {
	    $urlQuery = QueryGeneratorService::generateQuery($filters, $sorting = []);

        return $this->request->handleWithExceptions(function () use ($urlQuery) {
	        $response = $this->request->doRequest('get', "{$this->rest_version}/{$this->entity}{$urlQuery}");

            $items = collect([]);
			foreach ( json_decode($response->getBody()->getContents())->collection as $item ) {
                /** @var Model $model */
                $model = new $this->model($this->request, $item);

                $items->push($model);
            }

			$response->getBody()->close();

            return $items;
        });
    }

	/**
	 * @param int   $page
	 * @param int   $pageSize
	 * @param array $filters
	 *
	 * @return \Illuminate\Support\Collection|Model[]
	 * @throws \LasseRafn\Economic\Exceptions\EconomicClientException
	 * @throws \LasseRafn\Economic\Exceptions\EconomicRequestException
	 */
    public function getByPage($page = 0, $pageSize = 500, $filters = [])
    {
        $items = collect([]);

        $urlQuery = QueryGeneratorService::generateQuery($filters, [] ,true);

        return $this->request->handleWithExceptions(function () use ($pageSize, &$page, &$items, $urlQuery) {
	        $response = $this->request->doRequest('get', "{$this->rest_version}/{$this->entity}?skippages={$page}&pagesize={$pageSize}{$urlQuery}");

			foreach ( json_decode($response->getBody()->getContents())->collection as $item ) {
                /** @var Model $model */
                $model = new $this->model($this->request, $item);

                $items->push($model);
            }

			$response->getBody()->close();

            return $items;
        });
    }

	/**
	 * @param array $filters
	 * @param int   $pageSize
	 *
	 * @return \Illuminate\Support\Collection|Model[]
	 * @throws \LasseRafn\Economic\Exceptions\EconomicClientException
	 * @throws \LasseRafn\Economic\Exceptions\EconomicRequestException
	 */
    public function all($filters = [], $sorting = [], $pageSize = 100)
    {
		$page    = 0;
        $page = 0;
        $hasMore = true;
        $items = collect([]);

	    $urlQuery = QueryGeneratorService::generateQuery($filters, $sorting, true);

        return $this->request->handleWithExceptions(function () use (&$hasMore, $pageSize, &$page, &$items, $urlQuery) {
            while ($hasMore) {
	            $response = $this->request->doRequest('get', "{$this->rest_version}/{$this->entity}?skippages={$page}&pagesize={$pageSize}{$urlQuery}");

				$fetchedItems = empty( $this->rest_version ) ? json_decode($response->getBody()->getContents())->collection : json_decode($response->getBody()->getContents());

				$response->getBody()->close();

                foreach ($fetchedItems as $item) {
                    /** @var Model $model */
                    $model = new $this->model($this->request, $item);

                    $items->push($model);
                }

	            // If we got fewer items returned than requested, it means we reached page limit
	            // Using min() to ensure $pageSize > 1000 doesn't cause infinite loops
	            // Since e-conomic max pageSize is 1000.
	            if (count($fetchedItems) < min($pageSize, 1000)) {
		            $hasMore = false;
					break;
	            }

                $page++;
            }

            return $items;
        });
    }

	/**
	 * @param $data
	 *
	 * @return Model
	 * @throws \LasseRafn\Economic\Exceptions\EconomicClientException
	 * @throws \LasseRafn\Economic\Exceptions\EconomicRequestException
	 */
    public function create($data)
    {
    	$data = $this->request->formatData($data);

        return $this->request->handleWithExceptions(function () use ($data) {
	        $response = $this->request->doRequest('post', "{$this->rest_version}/{$this->entity}", [
		     'json' => $data
	      	]);

		$responseData = json_decode($response->getBody()->getContents());

		$response->getBody()->close();

            return new $this->model($this->request, $responseData);
        });
    }

    /**
     * @param array $filters
     * @param int   $pageSize
     *
     * @return \Generator
     * @throws \LasseRafn\Economic\Exceptions\EconomicClientException
     * @throws \LasseRafn\Economic\Exceptions\EconomicRequestException
     */
    public function allWithGenerators($filters = [], $sorting = [], $pageSize = 500)
    {
        $page = 0;
        $hasMore = true;
        $items = collect([]);

        $urlQuery = QueryGeneratorService::generateQuery($filters, $sorting, true);

        return $this->request->handleWithExceptions(function () use (&$hasMore, $pageSize, &$items, &$page, $urlQuery) {
            while ($hasMore) {
                $responseData = $this->getRequest($page, $pageSize, $urlQuery);

                $items = $this->parseResponse($responseData, $items);

	            foreach ($items as $result){
		            yield $result;
	            }

                // If we got fewer items returned than requested, it means we reached page limit
                // Using min() to ensure $pageSize > 1000 doesn't cause infinite loops
                // Since e-conomic max pageSize is 1000.
                if (count($responseData->collection) < min($pageSize, 1000)) {
                    $hasMore = false;

                    break;
                }

                $page++;
            }

            return $items;
        });
    }

    protected function getRequest($page, $pageSize, $urlFilters)
    {
        $response =  $this->request->doRequest('get', "/{$this->entity}?skippages={$page}&pagesize={$pageSize}{$urlFilters}");
        return json_decode($response->getBody()->getContents());
    }

    public function parseResponse($responseData, \Illuminate\Support\Collection $items): \Illuminate\Support\Collection
    {

        foreach ($responseData->collection as $item) {
            $model = new $this->model($this->request, $item);

            $items->push($model);
        }

        return $items;
    }
}
