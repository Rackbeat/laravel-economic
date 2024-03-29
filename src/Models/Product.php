<?php

namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Builders\ProductBuilder;
use LasseRafn\Economic\Builders\ProductCurrencyPriceBuilder;
use LasseRafn\Economic\Utils\Model;

class Product extends Model
{
	protected $entity     = 'products';
	protected $primaryKey = 'productNumber';

	protected $puttable = [
		'productNumber',
		'name',
		'description',
		'costPrice',
		'recommendedPrice',
		'salesPrice',
		'barCode',
		'barred',
		'inventory',
		'unit',
		'productGroup',
		'departmentalDistribution',
	];

	protected function getUpdateEndpoint()
	{
		return $this->self;
	}

	public $productNumber;
	public $departmentalDistribution;
	public $name;
	public $self;
	public $unit;
	public $description;
	public $recommendedPrice = 0;
	public $salesPrice       = 0;
	public $costPrice        = 0;

	/**
	 * @var object productGroup
	 */
	public $productGroup;

	/**
	 * @return ProductCurrencyPriceBuilder
	 */
	public function currencyPrices()
	{
		return new ProductCurrencyPriceBuilder(
			$this->request,
			( new ProductBuilder( $this->request ) )->encode( $this->productNumber )
		);
	}
}
