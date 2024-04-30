<?php

namespace LasseRafn\Economic\Builders;

use LasseRafn\Economic\Models\Department;

class DepartmentBuilder extends Builder
{
	protected $entity = 'departments';
	protected $model  = Department::class;
}
