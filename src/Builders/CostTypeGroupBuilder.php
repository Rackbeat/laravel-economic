<?php

namespace LasseRafn\Economic\Builders;

use LasseRafn\Economic\Models\CostTypeGroup;

class CostTypeGroupBuilder extends Builder
{
	protected $entity = 'costtypegroups';
	protected $model = CostTypeGroup::class;
}
