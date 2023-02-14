<?php

namespace LasseRafn\Economic\Builders;

use LasseRafn\Economic\Models\ProductCurrencyPrice;
use LasseRafn\Economic\Utils\Request;

class ProductCurrencyPriceBuilder extends Builder
{
    protected $entity = '/products/:productNumber/pricing/currency-specific-sales-prices';
    protected $model = ProductCurrencyPrice::class;

    public function __construct(Request $request, $productNumber)
    {
        $this->entity = str_replace(':productNumber', $productNumber, $this->entity);

        parent::__construct($request);
    }
}
