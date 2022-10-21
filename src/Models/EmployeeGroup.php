<?php


namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;


class EmployeeGroup extends Model
{
    protected $entity = 'employeegroups';
    protected $primaryKey = 'number';
    protected $puttable = [
        'name',
        'number',
    ];

    public $number;
    public $name;
    public $self;

}