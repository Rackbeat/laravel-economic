<?php

namespace LasseRafn\Economic\Builders;

class AdditionalLagerDataBuilder extends Builder
{
    protected $entity = 'rackbeat-extradata';

    /**
     * @param array $filters
     *
     * @return \Illuminate\Support\Collection|Model[]
     * @throws \LasseRafn\Economic\Exceptions\EconomicClientException
     * @throws \LasseRafn\Economic\Exceptions\EconomicRequestException
     */
    public function get($filters = [])
    {
        $urlFilters = $this->generateQueryStringFromFilterArray($filters);

        return $this->request->handleWithExceptions(function () use ($urlFilters) {
            $response = $this->request->doRequest('get', "{$this->rest_version}/{$this->entity}{$urlFilters}");

            return json_decode($response->getBody()->getContents());
        });
    }
}
