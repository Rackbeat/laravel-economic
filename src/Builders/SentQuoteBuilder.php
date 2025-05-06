<?php 

namespace LasseRafn\Economic\Builders;

use LasseRafn\Economic\Models\SentQuote;

class SentQuoteBuilder extends Builder
{
	protected $entity = 'quotes/sent';
	protected $model  = SentQuote::class;
}