<?php 

namespace LasseRafn\Economic\Builders\ResourceApi\Journals;

use LasseRafn\Economic\Builders\ResourceApi\RestResourceBuilder;
use LasseRafn\Economic\Models\BookedJournal;

class JournalBookingBuilder extends RestResourceBuilder
{
	protected $rest_api = 'journalsapi';
	protected $entity = 'journals';
	protected $rest_version = 'v14.0.1';
	protected $model  = BookedJournal::class;

	public function bookEntries(string $journalNumber, array $entryNumbers)
	{
		return $this->request->handleWithExceptions( function () use($journalNumber, $entryNumbers) {
			$response = $this->request->doRequest('post', "{$this->rest_version}/{$this->entity}/{$journalNumber}/bookdraftentries", [
		     	'json' => $entryNumbers
	      	]);

			$responseData = json_decode( $response->getBody()->getContents() );

			$model = new $this->model( $this->request, $responseData );

			return $model;
		} );
	}
}