<?php

namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class Department extends Model
{
    protected $entity = 'department';
    protected $primaryKey = 'number';

    public $departmentNumber;
    public $name;
    public $barred;
}
