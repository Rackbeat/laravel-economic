<?php

namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class CostType extends Model
{
	protected $entity = 'costtypes';
	protected $primaryKey = 'number';
	protected $puttable = [
		'costGroupNumber',
		'name',
		'number',
		'isBarred',
	];

	public $name;
	public $number;
	public $costGroupNumber;
	public $vatCode;
	public $lastUpdated;
	public $self;
}
