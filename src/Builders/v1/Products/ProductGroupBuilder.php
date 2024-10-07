<?php

namespace LasseRafn\Economic\Builders\v1\Products;

use LasseRafn\Economic\Builders\v1\RestBuilderV1;
use LasseRafn\Economic\Models\ProductGroup;

class ProductGroupBuilder extends RestBuilderV1
{
	protected $rest_api = 'productsapi';
	protected $entity = 'productgroups';
	protected $model  = ProductGroup::class;
}
