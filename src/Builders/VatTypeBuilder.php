<?php

namespace LasseRafn\Economic\Builders;

use LasseRafn\Economic\Models\VatType;

class VatTypeBuilder extends Builder
{
	protected $entity = 'vat-types';
	protected $model  = VatType::class;
}
