<?php

namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class Employee extends Model
{
    protected $entity = 'employees';
    protected $primaryKey = 'number';

    public $barred;
    public $bookedInvoices;
    public $customers;
    public $draftInvoices;
    public $email;
    public $employeeGroup;
    public $number;
    public $name;
    public $phone;
    public $self;
}
