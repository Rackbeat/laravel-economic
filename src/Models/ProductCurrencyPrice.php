<?php

namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class ProductCurrencyPrice extends Model
{
	protected $entity     = 'products/:productNumber/pricing/currency-specific-sales-prices';
	protected $primaryKey = 'code';

	public $currency;
	public $price;
	public $self;
}
