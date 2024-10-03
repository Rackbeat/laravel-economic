<?php

namespace LasseRafn\Economic\Builders\v1\Products;

use LasseRafn\Economic\Models\ProductGroup;

class ProductGroupBuilder extends ProductApiRestBuilder
{
	protected $entity = 'productgroups';
	protected $model  = ProductGroup::class;
}
