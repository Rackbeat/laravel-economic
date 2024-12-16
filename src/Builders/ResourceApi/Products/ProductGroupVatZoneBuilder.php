<?php

namespace LasseRafn\Economic\Builders\ResourceApi\Products;

use LasseRafn\Economic\Builders\ResourceApi\RestResourceBuilder;
use LasseRafn\Economic\Models\ProductGroupVatZone;
use LasseRafn\Economic\Utils\Request;

class ProductGroupVatZoneBuilder extends RestResourceBuilder
{
	public function __construct(Request $request, $productGroup)
	{
		parent::__construct($request);
		$this->entity = str_replace( ':productGroupNumber', $productGroup, $this->entity );
	}

	protected $rest_api = 'productsapi';
	protected $entity = 'productgroups/:productGroupNumber/zones';
	protected $rest_version = 'v1.1.0';
	protected $model  = ProductGroupVatZone::class;
}
