<?php

namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class ExternalBillingItem extends Model
{
	protected $entity     = 'ExternalBillingItems';
	protected $primaryKey = 'id';
	protected $rest_version = 'Billingsapi/v1.2.0';

	public $id;
	public $licenseModuleId;
	public $registeredDate;
	public $deregisteredDate;
	public $billingText;
	public $discountPercentage;
	public $discountExpiry;
	public $externalId;
	public $agreementNumber;
	public $pricePerMonth;
	public $pricePerMonthExpiry;
	public $pricePerMonthText;
	public $quantity;
}
