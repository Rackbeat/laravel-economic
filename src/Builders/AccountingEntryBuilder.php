<?php

namespace LasseRafn\Economic\Builders;

use LasseRafn\Economic\Models\AccountingEntry;
use LasseRafn\Economic\Utils\Request;

class AccountingEntryBuilder extends Builder
{
	protected $entity = 'accounts/:account/accounting-years/:accountingYear/periods/:periodNumber/entries';
	protected $model  = AccountingEntry::class;

	public function __construct( Request $request, $account, $year, $period )
	{
		$this->entity = str_replace( ':accountingYear', $year, $this->entity );
		$this->entity = str_replace( ':account', $account, $this->entity );
		$this->entity = str_replace( ':periodNumber', $period, $this->entity );

		parent::__construct( $request );
	}
}
