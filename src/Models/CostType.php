<?php

namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class CostType extends Model
{
	protected $entity = 'costtypes';
	protected $primaryKey = 'number';
	protected $rest_version = '/api/v16.0.0';
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
