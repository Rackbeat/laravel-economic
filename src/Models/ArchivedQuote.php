<?php 

namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class ArchivedQuote extends Model
{
	protected $entity     = 'quotes/archived';
	protected $primaryKey = 'quoteNumber';

	public $quoteNumber;
}