<?php 

namespace LasseRafn\Economic\Builders;

use LasseRafn\Economic\Models\ArchivedQuote;

class ArchivedQuoteBuilder extends Builder
{
	protected $entity = 'quotes/archived';
	protected $model  = ArchivedQuote::class;
}