<?php

namespace LasseRafn\Economic\Builders;

use LasseRafn\Economic\Models\AccountingPeriodTotals;
use LasseRafn\Economic\Utils\Request;

class AccountingPeriodTotalsBuilder extends Builder
{
	protected $entity = 'accounts/:account/accounting-years/:accountingYear/periods/:period/totals';

	protected $model = AccountingPeriodTotals::class;

	public function __construct(Request $request, $account, $year, $period)
	{
		$this->entity = str_replace(':accountingYear', $year, $this->entity);
		$this->entity = str_replace(':account', $account, $this->entity);
		$this->entity = str_replace(':period', $period, $this->entity);

		parent::__construct($request);
	}
}
