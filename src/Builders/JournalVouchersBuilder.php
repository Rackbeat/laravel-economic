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

		$agreementToken = $this->request->curl->getOptions()['headers']['X-AgreementGrantToken'];
		$apiSecret      = $this->request->curl->getOptions()['headers']['X-AppSecretToken'];

		return $this->request->handleWithExceptions( function () use ( $pdf, $voucherNumber, $apiSecret, $agreementToken ) {
			$response = Http::attach(
				(string) $voucherNumber,
				$pdf,
				(string) $voucherNumber . '.pdf'
			)->withHeaders( [
				'X-AppSecretToken'      => $apiSecret,
				'X-AgreementGrantToken' => $agreementToken,
			] )->post( config( 'economic.request_endpoint' ) . "{$this->rest_version}/{$this->entity}" );

			$responseData = $response->throw()->object();

			$response->close();

			return new $this->model( $this->request, $responseData );
		} );
	}
}
