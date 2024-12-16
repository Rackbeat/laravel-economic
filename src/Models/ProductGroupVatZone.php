<?php

namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class ProductGroupVatZone extends Model
{
	protected $entity = 'productgroups/:productGroupNumber/zones';
	protected $primaryKey = 'id';
	protected $rest_version = 'v1.1.0';

	public $id;
	public $accountId;
}
