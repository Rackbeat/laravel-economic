<?php


namespace LasseRafn\Economic\Builders;


use Illuminate\Support\Facades\Log;
use LasseRafn\Economic\Models\JournalVouchers;
use LasseRafn\Economic\Utils\Request;

class JournalVouchersBuilder extends Builder
{
	protected $entity = 'journals/:journalNumber/vouchers';
	protected $model  = JournalVouchers::class;


	public function __construct( Request $request, $journalNumber )
	{
		$this->entity = str_replace( ':journalNumber', $journalNumber, $this->entity );

		parent::__construct( $request );
	}

	public function uploadVoucherPdf( $accountingYear, $voucherNumber, $pdf )
	{
		$this->entity .= '/' . $accountingYear . '-' . $voucherNumber . '/attachment/file';

		return $this->request->handleWithExceptions( function () use ( $pdf, $voucherNumber ) {
			$this->request->curl->contentType('application/x-www-form-urlencoded'); // so it can handle file upload
			
			$response = $this->request->doRequest( 'post', "{$this->rest_version}/{$this->entity}", [
				[
					'name'     => (string) $voucherNumber,
					'contents' => $pdf,
					'filename' => (string) $voucherNumber . '.pdf',
				],
			]);

			$responseData = $response->throw()->json();

			$response->close();

			return new $this->model( $this->request, $responseData );
		} );
	}
}
