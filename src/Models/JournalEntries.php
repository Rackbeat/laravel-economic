<?php


namespace LasseRafn\Economic\Models;


use Illuminate\Support\Facades\Log;
use LasseRafn\Economic\Utils\Request;

class JournalEntries extends \LasseRafn\Economic\Utils\Model
{
	protected $entity = 'journals/:journalNumber/entries';

	public $journalNumber;
	public $entries;
	public $name;

	public function __construct( Request $request, $data )
	{
		if ( $data && is_array( $data ) ) {
			$data                = $data[0];
			$this->journalNumber = $data->journal->journalNumber;
			$this->entity        = str_replace( ':journalNumber', $this->journalNumber, $this->entity );
		}

		parent::__construct( $request, $data );
	}
}