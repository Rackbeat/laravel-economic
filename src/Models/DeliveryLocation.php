<?php

namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class DeliveryLocation extends Model
{
	protected $entity     = 'customerdeliverylocation';
	protected $primaryKey = 'number';
    protected $puttable   = [
        'number',
        'address',
        'barred',
        'city',
        'country',
        'customerNumber',
        'deliveryLocationNumber',
        'postalCode',
        'termsOfDelivery'
    ];

    public $number;
    public $address;
    public $barred;
    public $city;
    public $country;
    public $customerNumber;
    public $deliveryLocationNumber;
    public $postalCode;
    public $termsOfDelivery;
}
