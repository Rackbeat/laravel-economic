<?php

namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;
use LasseRafn\Economic\Utils\Request;

class CustomerAddress extends Model
{
	protected $entity     = 'customers/:customerNumber/delivery-locations';
	protected $primaryKey = 'deliveryLocationNumber';
	protected $puttable   = [
		'address',
		'barred',
		'city',
		'country',
		'customerNumber',
		'deliveryLocationNumber',
		'postalCode',
		'termsOfDelivery'
	];

	public $address;
	public $barred;
	public $city;
	public $country;
	public $customerNumber;
	public $deliveryLocationNumber;
	public $postalCode;
	public $termsOfDelivery;

	/** @var Customer $customer */
	public $customer;

	public function __construct( Request $request, $data )
	{
		$this->entity = str_replace( ':customerNumber', $data->customer->customerNumber, $this->entity );

		parent::__construct( $request, $data );
	}
}