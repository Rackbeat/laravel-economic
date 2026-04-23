<?php

namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class ProductGroup extends Model
{
	protected $entity     = 'productgroups';
	protected $primaryKey = 'id';
	protected $rest_version = 'productsapi/v1.1.0';

	public $id;
	public $name;
	public $domesticAccountId;
	public $objectVersion;
}
