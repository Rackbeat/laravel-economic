<?php

namespace LasseRafn\Economic\Builders;

use LasseRafn\Economic\Builders\ResourceApi\RestResourceBuilder;
use LasseRafn\Economic\Models\ExternalBillingItem;
use LasseRafn\Economic\Utils\Model;
use LasseRafn\Economic\Utils\Request;

class BillingItemBuilder extends RestResourceBuilder
{
	protected $rest_api = 'Billingsapi';
	protected $rest_version = 'v1.2.0';
	protected $entity = 'ExternalBillingItems';
	protected $model = ExternalBillingItem::class;

	/**
	 * @param int      $id
	 * @param int|null $agreementNumber Only required when the token is not scoped to a specific agreement
	 *
	 * @return Model|ExternalBillingItem
	 * @throws \LasseRafn\Economic\Exceptions\EconomicClientException
	 * @throws \LasseRafn\Economic\Exceptions\EconomicRequestException
	 */
	public function find($id, $agreementNumber = null)
	{
		return $this->request->handleWithExceptions(function () use ($id, $agreementNumber) {
			$path = "{$this->rest_version}/{$this->entity}/{$id}";

			if ($agreementNumber !== null) {
				$path .= "/{$agreementNumber}";
			}

			$response = $this->request->doRequest('get', $path);

			$responseData = json_decode($response->getBody()->getContents());

			$response->getBody()->close();

			return new $this->model($this->request, $responseData);
		});
	}

	/**
	 * @param int   $page
	 * @param int   $pageSize
	 * @param array $filters
	 *
	 * @return \Illuminate\Support\Collection|ExternalBillingItem[]
	 * @throws \LasseRafn\Economic\Exceptions\EconomicClientException
	 * @throws \LasseRafn\Economic\Exceptions\EconomicRequestException
	 */
	public function getByPage($page = 0, $pageSize = 500, $filters = [])
	{
		$items = collect([]);

		$urlQuery = \LasseRafn\Economic\Services\QueryGeneratorService::generateQuery($filters, [], true);

		return $this->request->handleWithExceptions(function () use ($pageSize, &$page, &$items, $urlQuery) {
			$response = $this->request->doRequest('get', "{$this->rest_version}/{$this->entity}/paged?skipPages={$page}&pageSize={$pageSize}{$urlQuery}");

			foreach ($this->getItemsFromResponse($response) as $item) {
				$model = new $this->model($this->request, $item);
				$items->push($model);
			}

			$response->getBody()->close();

			return $items;
		});
	}

	/**
	 * @param array $filters
	 * @param array $sorting
	 * @param int   $pageSize
	 *
	 * @return \Illuminate\Support\Collection|ExternalBillingItem[]
	 * @throws \LasseRafn\Economic\Exceptions\EconomicClientException
	 * @throws \LasseRafn\Economic\Exceptions\EconomicRequestException
	 */
	public function all($filters = [], $sorting = [], $pageSize = 100)
	{
		$page = 0;
		$hasMore = true;
		$items = collect([]);

		$urlQuery = \LasseRafn\Economic\Services\QueryGeneratorService::generateQuery($filters, $sorting, true);

		return $this->request->handleWithExceptions(function () use (&$hasMore, $pageSize, &$page, &$items, $urlQuery) {
			while ($hasMore) {
				$response = $this->request->doRequest('get', "{$this->rest_version}/{$this->entity}/paged?skipPages={$page}&pageSize={$pageSize}{$urlQuery}");

				$fetchedItems = $this->getItemsFromResponse($response);

				$response->getBody()->close();

				foreach ($fetchedItems as $item) {
					$model = new $this->model($this->request, $item);
					$items->push($model);
				}

				if (count($fetchedItems) < min($pageSize, 100)) {
					$hasMore = false;
					break;
				}

				$page++;
			}

			return $items;
		});
	}

	/**
	 * @param array $data
	 *
	 * @return Model|ExternalBillingItem
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
	 * @param array $items Array of ExternalBillingItem data
	 *
	 * @return \Illuminate\Support\Collection ids of the created items
	 * @throws \LasseRafn\Economic\Exceptions\EconomicClientException
	 * @throws \LasseRafn\Economic\Exceptions\EconomicRequestException
	 */
	public function bulkCreate(array $items)
	{
		$items = array_map(function ($item) {
			return $this->request->formatData($item);
		}, $items);

		return $this->request->handleWithExceptions(function () use ($items) {
			$response = $this->request->doRequest('post', "{$this->rest_version}/{$this->entity}/bulk", [
				'json' => $items
			]);

			// Response shape: { "ids": [int64, ...] } — not an array of full items
			$responseData = json_decode($response->getBody()->getContents());

			$response->getBody()->close();

			return collect($responseData->ids);
		});
	}

	/**
	 * @param int         $id
	 * @param string      $deregisteredDate
	 * @param int|null    $agreementNumber
	 *
	 * @return void
	 * @throws \LasseRafn\Economic\Exceptions\EconomicClientException
	 * @throws \LasseRafn\Economic\Exceptions\EconomicRequestException
	 */
	public function deregister(int $id, string $deregisteredDate, ?int $agreementNumber = null)
	{
		$payload = [
			'id'               => $id,
			'deregisteredDate' => $deregisteredDate,
		];

		if ($agreementNumber !== null) {
			$payload['agreementNumber'] = $agreementNumber;
		}

		return $this->request->handleWithExceptions(function () use ($payload) {
			$response = $this->request->doRequest('post', "{$this->rest_version}/{$this->entity}/deregister", [
				'json' => $payload
			]);

			$response->getBody()->close();
		});
	}

	/**
	 * @param int      $id
	 * @param int|null $agreementNumber
	 *
	 * @return void
	 * @throws \LasseRafn\Economic\Exceptions\EconomicClientException
	 * @throws \LasseRafn\Economic\Exceptions\EconomicRequestException
	 */
	public function reenable(int $id, ?int $agreementNumber = null)
	{
		$payload = [
			'id' => $id,
		];

		if ($agreementNumber !== null) {
			$payload['agreementNumber'] = $agreementNumber;
		}

		return $this->request->handleWithExceptions(function () use ($payload) {
			$response = $this->request->doRequest('post', "{$this->rest_version}/{$this->entity}/reenable", [
				'json' => $payload
			]);

			$response->getBody()->close();
		});
	}
}
