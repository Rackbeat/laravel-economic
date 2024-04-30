<?php


namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class ProjectGroup extends Model
{
	protected $entity       = 'projectgroups';
	protected $primaryKey   = 'number';
	protected $rest_version = '/api/v16.0.0';
	protected $puttable     = [
		'name',
		'type',
	];

	public $name;
	public $type;
	public $self;

}