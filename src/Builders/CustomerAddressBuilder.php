<?php

namespace LasseRafn\Economic\Builders;

use LasseRafn\Economic\Models\CustomerAddress;
use LasseRafn\Economic\Utils\Request;

class CustomerAddressBuilder extends Builder
{
    protected $entity = 'customers/:customerNumber/delivery-locations';
    protected $model = CustomerAddress::class;

    public function __construct(Request $request, $customerNumber)
    {
        $this->entity = str_replace(':customerNumber', $customerNumber, $this->entity);

        parent::__construct($request);
    }
}
