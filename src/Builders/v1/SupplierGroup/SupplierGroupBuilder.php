<?php

namespace LasseRafn\Economic\Builders\v1\SupplierGroup;

use LasseRafn\Economic\Builders\v1\RestBuilderV1;
use LasseRafn\Economic\Models\SupplierGroup;

class SupplierGroupBuilder extends RestBuilderV1
{
	protected $rest_api = 'suppliersapi';
	protected $entity = 'Groups';
	protected $model  = SupplierGroup::class;
}
