<?php

namespace LasseRafn\Economic\Builders;

use LasseRafn\Economic\Models\ProductGroup;

class ProductGroupBuilder extends Builder
{
	protected $entity = 'productgroups';
	protected $model  = ProductGroup::class;
	protected $rest_version = 'v1.1.0';
}
