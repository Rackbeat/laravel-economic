<?php 

namespace LasseRafn\Economic\Builders;

use LasseRafn\Economic\Models\DraftQuote;

class DraftQuoteBuilder extends Builder
{
	protected $entity = 'quotes/drafts';
	protected $model  = DraftQuote::class;
}