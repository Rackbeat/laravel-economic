<?php

namespace LasseRafn\Economic\Builders;

use LasseRafn\Economic\Models\CostType;

class CostTypeBuilder extends newRestBuilder
{
	protected $entity = 'costtypes';
	protected $model = CostType::class;
}
