<?php

namespace LasseRafn\Economic\Builders;

use LasseRafn\Economic\Models\DeliveryLocation;

class DeliveryLocationBuilder extends Builder
{
	protected $entity = 'customersapi/v1.1.1/DeliveryLocations';
	protected $model  = DeliveryLocation::class;
    
}
