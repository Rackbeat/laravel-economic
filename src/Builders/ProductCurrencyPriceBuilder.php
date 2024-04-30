<?php

namespace LasseRafn\Economic\Builders;

use LasseRafn\Economic\Models\ProductCurrencyPrice;
use LasseRafn\Economic\Utils\Model;
use LasseRafn\Economic\Utils\Request;

class ProductCurrencyPriceBuilder extends Builder
{
	public const VALID_CURRENCIES = [ 'DKK', 'EUR', 'GBP', 'NOK', 'SEK', 'USD' ];
	protected $entity = 'products/:productNumber/pricing/currency-specific-sales-prices';
	protected $model  = ProductCurrencyPrice::class;

	public function __construct( Request $request, $productNumber )
	{
		$this->entity = str_replace( ':productNumber', $productNumber, $this->entity );

		parent::__construct( $request );
	}

	public function valid()
	{
		return $this->all( [] )->filter( function ( $currency ) {
			return in_array( $currency->currency->code, self::VALID_CURRENCIES );
		} )->values();
	}
}
