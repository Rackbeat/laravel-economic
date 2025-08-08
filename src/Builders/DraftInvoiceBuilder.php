<?php

namespace LasseRafn\Economic\Builders;

use LasseRafn\Economic\Models\DraftInvoice;
use LasseRafn\Economic\Utils\Request;

class DraftInvoiceBuilder extends Builder
{
	protected $entity = 'invoices/drafts';
	protected $model  = DraftInvoice::class;

	public function uploadVoucherPdf( $draftInvoiceNumber, $pdf )
	{
		$url = $this->entity . "/$draftInvoiceNumber/attachment/file";

		$agreementToken = $this->request->curl->getConfig( 'headers' )['X-AgreementGrantToken'];
		$apiSecret      = $this->request->curl->getConfig( 'headers' )['X-AppSecretToken'];

		$this->request = new Request( $agreementToken, $apiSecret, false, null, 'multipart/form-data' );

		return $this->request->handleWithExceptions( function () use ( $pdf, $url, $draftInvoiceNumber ) {

			$response = $this->request->doRequest( 'post', "{$this->rest_version}/{$url}", [
				'multipart' => [
					[
						'name'     => 'PDF attachment',
						'contents' => $pdf,
						'filename' => "$draftInvoiceNumber.pdf",
					],
				],
			] );

			$responseData = json_decode( $response->getBody()->getContents() );

			$response->getBody()->close();

			return new $this->model( $this->request, $responseData );
		} );
	}
}
