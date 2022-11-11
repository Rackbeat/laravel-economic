<?php


namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;


class EmployeeGroup extends Model
{
    protected $entity = 'employeegroups';
    protected $rest_version = '/api/v16.0.0';
    protected $primaryKey = 'number';
    protected $puttable = [
        'name',
        'number',
    ];

    public $number;
    public $name;
    public $self;

}