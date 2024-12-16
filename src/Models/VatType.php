<?php

namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class VatType extends Model
{
	protected $entity     = 'vat-types';
	protected $primaryKey = 'vatTypeNumber';

	public int $vatTypeNumber;
	public string $name;
	public string $self;
}
