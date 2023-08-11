<?php

namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class AccountingPeriod extends Model
{
	protected $entity = ' /accounts/:account/accounting-years/:accountingYear/periods';
	protected $primaryKey = 'accountingPeriod';
}