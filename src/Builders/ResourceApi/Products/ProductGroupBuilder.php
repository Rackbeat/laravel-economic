<?php

namespace LasseRafn\Economic\Builders\ResourceApi\Products;

use LasseRafn\Economic\Builders\ResourceApi\RestResourceBuilder;
use LasseRafn\Economic\Models\ProductGroup;

class ProductGroupBuilder extends RestResourceBuilder
{
	protected $rest_api = 'productsapi';
	protected $entity = 'productgroups';
	protected $rest_version = 'v1.1.0';
	protected $model  = ProductGroup::class;
}
