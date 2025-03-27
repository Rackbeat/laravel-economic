<?php 

namespace LasseRafn\Economic\Builders\ResourceApi\Customers;

use LasseRafn\Economic\Builders\ResourceApi\RestResourceBuilder;

use LasseRafn\Economic\Models\ResourceContact;

class CustomerContactBuilder extends RestResourceBuilder
{
	protected $rest_api = 'customersapi';
	protected $entity = 'Contacts';
	protected $rest_version = 'v1.1.1';
	protected $model  = ResourceContact::class;
}