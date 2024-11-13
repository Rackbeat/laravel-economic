<?php

namespace LasseRafn\Economic\Builders;

use Illuminate\Support\Facades\Http;

class RackbeatEndpointBuilder
{
	protected string $economicRackbeatApiToken;
	protected string $basePath = 'https://secure.e-conomic.com/secure/rackbeat/';

	public function __construct( string $economicRackbeatApiToken = '' )
	{
		$this->economicRackbeatApiToken = $economicRackbeatApiToken;
	}

	public function generateToken( $economicAgreementNumber )
	{
		return $this->sendGetRequest( 'generate-token?agreementNumber=' . $economicAgreementNumber );
	}

	public function getRackbeatExtraData()
	{
		return $this->sendGetRequest( 'get-all-data?token=' . $this->economicRackbeatApiToken );
	}

	public function getDocumentCategories()
	{
		return $this->sendGetRequest( 'get-document-categories?token=' . $this->economicRackbeatApiToken );
	}

	public function getDocument( int $documentId )
	{
		return $this->sendGetRequest( 'get-document?token=' . $this->economicRackbeatApiToken . '&documentId=' . $documentId );
	}

	public function getUnprocessedDocuments()
	{
		return $this->sendGetRequest( 'get-unprocessed-documents?token=' . $this->economicRackbeatApiToken );
	}

	public function getDocumentsByCategory( int $categoryId )
	{
		return $this->sendGetRequest( 'get-documents-by-category?token=' . $this->economicRackbeatApiToken . '&categoryId=' . $categoryId );
	}

	public function bookAndSendInformation( int $draftId )
	{
		return $this->sendGetRequest( 'book-and-send-information?token=' . $this->economicRackbeatApiToken . '&draftId=' . $draftId );
	}

	public function attachDocumentToJournal( string $jsonEncodedData, array $data )
	{
		return $this->sendPostRequest(
			'attach-document-to-journal?token=' . $this->economicRackbeatApiToken,
			$jsonEncodedData,
			$data
		);
	}

	public function bookJournal( string $jsonEncodedData, array $data )
	{
		return $this->sendPostRequest(
			'book-journal?token=' . $this->economicRackbeatApiToken,
			$jsonEncodedData,
			$data
		);
	}

	public function bookAndSend( string $jsonEncodedData, array $data )
	{
		return $this->sendPostRequest(
			'book-and-send?token=' . $this->economicRackbeatApiToken,
			$jsonEncodedData,
			$data
		);
	}

	protected function sendGetRequest( $endpointUri )
	{
		return Http::retry( 3, 500, function ( $exception ) {
			return $exception->getCode() >= 500;
		} )->withHeaders( [
			'X-Signature'  => $this->getSignature(),
			'Content-Type' => 'application/json',
		] )->get( $this->basePath . $endpointUri );
	}

    protected function sendPostRequest( string $endpointUri, string $jsonEncodedPayload, array $payload )
	{
		return Http::retry( 3, 500, function ( $exception ) {
			return $exception->getCode() >= 500;
		} )->withHeaders( [
			'X-Signature'  => $this->getSignature( $jsonEncodedPayload ),
			'Content-Type' => 'application/json',
		] )->post( $this->basePath . $endpointUri, $payload );
	}

    protected function getSignature( $data = "" )
	{
		$key = config( 'economic.economic_rackbeat_rsa_key' );

		// Do not touch the formatting on this, it will stop working
		$private_key = <<<EOD
        $key
        EOD;

		$binary_signature = "";

		openssl_sign( $data, $binary_signature, $private_key, OPENSSL_ALGO_SHA256 );

		$signature = base64_encode( $binary_signature );

		return $signature;
	}
}