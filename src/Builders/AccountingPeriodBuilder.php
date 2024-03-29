<?php

namespace LasseRafn\Economic\Builders;

use LasseRafn\Economic\Models\AccountingPeriod;
use LasseRafn\Economic\Utils\Request;

class AccountingPeriodBuilder extends Builder
{
	protected $entity = 'accounts/:account/accounting-years/:accountingYear/periods';
	protected $model  = AccountingPeriod::class;

	public $year;
	public $account;

	public function __construct( Request $request, $account, $year )
	{
		$this->account = $account;
		$this->year    = $year;

		$this->entity = str_replace( ':accountingYear', $this->year, $this->entity );
		$this->entity = str_replace( ':account', $this->account, $this->entity );

		parent::__construct( $request );
	}
}
