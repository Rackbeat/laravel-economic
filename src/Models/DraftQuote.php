<?php

namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class DraftQuote extends Model
{
	protected $entity     = 'quotes';
	protected $primaryKey = 'quoteNumber';

	protected $puttable = [
		'quoteNumber',
    	'salesDocumentType',
    	'orderNumberDb',
    	'templates',
	    'attachment',
	    'lines',
	    'date',
	    'currency',
	    'exchangeRate',
	    'netAmount',
	    'netAmountInBaseCurrency',
	    'grossAmount',
	    'grossAmountInBaseCurrency',
	    'marginInBaseCurrency',
	    'marginPercentage',
	    'vatAmount',
	    'roundingAmount',
	    'costPriceInBaseCurrency',
	    'dueDate',
	    'paymentTerms',
	    'customer',
	    'recipient',
	    'deliveryLocation',
	    'references',
	    'layout',
	    'pdf',
	    'lastUpdated',
	    'self'
   	];

	public $quoteNumber;
	public $salesDocumentType;
	public $orderNumberDb;
	public $templates;
	public $attachment;
	public $lines;
	public $date;
	public $currency;
	public $exchangeRate;
	public $netAmount;
	public $netAmountInBaseCurrency;
	public $grossAmount;
	public $grossAmountInBaseCurrency;
	public $marginInBaseCurrency;
	public $marginPercentage;
	public $vatAmount;
	public $roundingAmount;
	public $costPriceInBaseCurrency;
	public $dueDate;
	public $paymentTerms;
	public $customer;
	public $recipient;
	public $deliveryLocation;
	public $references;
	public $layout;
	public $pdf;
	public $lastUpdated;
	public $self;
}
