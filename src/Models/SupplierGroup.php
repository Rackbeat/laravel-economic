<?php

namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class SupplierGroup extends Model
{
	protected $entity     = 'Groups';
	protected $primaryKey = 'number';
	protected $rest_version = 'suppliersapi/v2.0.0';

	public $accountNumber;
	public $name;
	public $number;
	public $objectVersion;
}
