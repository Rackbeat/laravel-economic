<?php

namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class CostTypeGroup extends Model
{
	protected $entity       = 'costtypegroups';
	protected $rest_version = '/api/v16.0.0';
	protected $primaryKey   = 'number';
	protected $puttable     = [
		'accountClosed',
		'accountOnGoing',
		'name',
		'number',
		'type',
		'markup'
	];

	public $name;
	public $number;
	public $accountClosed;
	public $accountOnGoing;
	public $type;
	public $markup;
	public $self;
}
