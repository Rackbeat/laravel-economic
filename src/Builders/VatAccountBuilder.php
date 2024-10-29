<?php

namespace LasseRafn\Economic\Builders;

use LasseRafn\Economic\Models\VatAccount;

class VatAccountBuilder extends Builder
{
	protected $entity = 'vat-accounts';
	protected $model  = VatAccount::class;
}
