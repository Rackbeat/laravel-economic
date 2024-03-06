<?php

namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class AccountingEntry extends Model
{
	protected $entity = 'accounts/:account/accounting-years/:accountingYear/periods/:periodNumber/entries';
	protected $primaryKey = 'entryNumber';

	public $entryNumber;
	public $amount;
	public $date;
}