<?php

namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class SentOrder extends Model
{
    public    $orderNumber;
    public    $name;
    protected $entity     = 'orders/sent';
    protected $primaryKey = 'orderNumber';
    protected $puttable = [
        'orderNumber',
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
        'paymentTerms',
        'customer',
        'recipient',
        'delivery',
        'references',
        'lines',
        'notes'
    ];
    public $self;
    public $pdf;
    public $date;
    public $currency;
    public $recipient;
    public $project;
    public $grossAmount;
    public $netAmount;
    public $delivery;
    public $customer;
    public $dueDate;
    public $exchangeRate;
    public $deliveryLocation;
    public $paymentTerms;
    public $grossAmountInBaseCurrency;
    public $soap;
    public $notes;
    public $lines;
}
