<?php


namespace LasseRafn\Economic\Builders;


use LasseRafn\Economic\Models\EmployeeGroup;

class EmployeeGroupBuilder extends NewRestBuilder
{
	protected $entity = 'employeegroups';
	protected $model  = EmployeeGroup::class;

}