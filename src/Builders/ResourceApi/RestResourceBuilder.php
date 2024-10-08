<?php

namespace LasseRafn\Economic\Builders\ResourceApi;

use LasseRafn\Economic\Builders\BaseBuilder;
use LasseRafn\Economic\Utils\Request;

class RestResourceBuilder extends BaseBuilder
{
	protected $rest_api = '';
	protected $rest_version = '';

	public function __construct(Request $request)
	{
		parent::__construct($request);
		$this->rest_version .= $this->rest_api . '/' . $this->rest_version;
	}

	/** Overrides BaseBuilder */
	protected function getItemsFromResponse($response){
		return json_decode($response->getBody()->getContents())->items;
	}
}