<?php

namespace LasseRafn\Economic\Builders\v1;

use LasseRafn\Economic\Builders\BaseBuilder;
use LasseRafn\Economic\Utils\Request;

class RestBuilderV1 extends BaseBuilder
{
	const VERSION = 'v1.1.0';

	protected $rest_api = '';
	protected $rest_version = '/';

	public function __construct(Request $request)
	{
		parent::__construct($request);
		$this->rest_version .= $this->rest_api . '/' . self::VERSION;
	}

	/** Overrides BaseBuilder */
	private function getItemsFromResponse($response){
		return json_decode($response->getBody()->getContents())->items;
	}
}