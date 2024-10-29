<?php

namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class VatAccount extends Model
{
	protected $entity     = 'vat-accounts';
	protected $primaryKey = 'vatCode'; // technically there is no primary key but this is the closest there is

	public string $vatCode;
	public string $name;
  	public ?Account $account = null;
  	public ?Account $contraAccount = null;
  	public $vatType;
  	public float $ratePercentage;
	public string $self;

	  public function setAccountAttribute($data) {
	    return new Account($this->request, $data);
	  }
	
	  public function setContraAccountAttribute($data) {
	    return new Account($this->request, $data);
	  }
	
	  public function seVatTypeAttribute($data) {
	    return new VatType($this->request, $data);
	  }
}
