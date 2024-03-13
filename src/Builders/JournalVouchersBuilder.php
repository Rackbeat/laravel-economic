<?php


namespace LasseRafn\Economic\Builders;


use Illuminate\Support\Facades\Http;
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

		$agreementToken = $this->request->curl->getConfig( 'headers' )['X-AgreementGrantToken'];
		$apiSecret      = $this->request->curl->getConfig( 'headers' )['X-AppSecretToken'];

		$this->request = new Request( $agreementToken, $apiSecret, false, null, 'multipart/form-data' );

		return $this->request->handleWithExceptions( function () use ( $pdf, $voucherNumber ) {

			$response = $this->request->doRequest( 'post', "{$this->rest_version}/{$this->entity}", [
				'multipart' => [
					[
						'name'     => (string) $voucherNumber,
						'contents' => $pdf,
						'filename' => (string) $voucherNumber . '.pdf',
					],
				],
			] );

			$responseData = json_decode( $response->getBody()->getContents() );

			$response->getBody()->close();

			return new $this->model( $this->request, $responseData );
		} );
	}
}
