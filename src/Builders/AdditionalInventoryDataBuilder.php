<?php

namespace LasseRafn\Economic\Builders;

use LasseRafn\Economic\Services\QueryGeneratorService;

class AdditionalInventoryDataBuilder extends Builder
{
	protected $entity = 'rackbeat-extradata';

	/**
	 * @param array $filters
	 *
	 * @return \Illuminate\Support\Collection|Model[]
	 * @throws \LasseRafn\Economic\Exceptions\EconomicClientException
	 * @throws \LasseRafn\Economic\Exceptions\EconomicRequestException
	 */
	public function get( $filters = [], $sorting = [] )
	{
		$urlFilters = QueryGeneratorService::generateQuery( $filters );

		return $this->request->handleWithExceptions( function () use ( $urlFilters ) {
			$response = $this->request->doRequest( 'get', "{$this->rest_version}/{$this->entity}{$urlFilters}" );

			return $response->object();
		} );
	}
}
