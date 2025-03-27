<?php 

namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class ResourceContact extends Model
{
	protected $entity     = 'Contacts';
	protected $primaryKey = 'number';
	protected $rest_version = 'v1.1.1';

    public $number;
    public $customerNumber;
    public $userInterfaceNumber;
    public $name;
    public $email;
    public $phone;
    public $notes;
    public $eInvoiceId;
    public $lastUpdated;
    public $receiveQuotes;
    public $receiveOrders;
    public $receiveInvoices;
    public $receiveEInvoices;
    public $receiveStatementOfAccounts;
    public $receiveReminders;
    public $objectVersion;
    public $isDeleted;
}