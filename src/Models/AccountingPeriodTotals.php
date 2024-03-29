<?php

namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class AccountingPeriodTotals extends Model
{
	protected $entity = 'accounts/:account/accounting-years/:accountingYear/periods/:periodNumber/totals';

	public $totalInBaseCurrency;
	public $account;
	public $fromDate;
	public $toDate;
}