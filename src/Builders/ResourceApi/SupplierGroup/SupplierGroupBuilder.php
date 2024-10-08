<?php

namespace LasseRafn\Economic\Builders\ResourceApi\SupplierGroup;

use LasseRafn\Economic\Builders\BaseBuilder;
use LasseRafn\Economic\Models\SupplierGroup;
use LasseRafn\Economic\Utils\Request;

class SupplierGroupBuilder extends BaseBuilder
{
	const VERSION = 'v1.0.1';

	protected $rest_api = 'suppliersapi';
	protected $entity = 'Groups';
	protected $model  = SupplierGroup::class;

	protected $rest_version = '/';

	public function __construct(Request $request)
	{
		parent::__construct($request);
		$this->rest_version .= $this->rest_api . '/' . self::VERSION;
	}

	/** Overrides BaseBuilder */
	protected function getItemsFromResponse($response){
		return json_decode($response->getBody()->getContents())->items;
	}
}
