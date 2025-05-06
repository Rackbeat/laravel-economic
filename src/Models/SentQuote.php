<?php 

namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;


class SentQuote extends Model
{
	protected $entity     = '/quotes/sent';
	protected $primaryKey = 'quoteNumber';

	protected $puttable = [
		'quoteNumber',
    	'salesDocumentType',
    	'orderNumberDb',
    	'templates',
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
	    'project',
	    'references',
	    'pdf',
	    'lastUpdated',
	    'self'
   	];

	public $quoteNumber;
	public $salesDocumentType;
	public $orderNumberDb;
	public $templates;
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
	public $delivery;
	public $references;
	public $project;
	public $notes;
	public $pdf;
	public $lastUpdated;
	public $soap;
	public $self;
}