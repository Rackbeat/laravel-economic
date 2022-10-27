<?php

namespace LasseRafn\Economic\Builders;

use LasseRafn\Economic\Models\Employee;

class EmployeeBuilder extends NewRestBuilder
{
    protected $entity = 'employees';
    protected $model = Employee::class;
}
