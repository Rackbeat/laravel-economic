<?php

namespace LasseRafn\Economic\Builders;

use Illuminate\Support\Facades\Http;

class RackbeatEndpointBuilder
{
    protected $model = RackbeatResponse::class;
    protected string $economicRackbeatApiToken;
    protected string $basePath = 'https://doppio.secure.e-conomic.com/secure/rackbeat/';

    public function __construct(string $economicRackbeatApiToken)
    {
        $this->economicRackbeatApiToken = $economicRackbeatApiToken;
    }

    public function generateToken($economicAgreementNumber)
    {
        return $this->sendGetRequest('generate-token?agreementNumber='.$economicAgreementNumber);
    }

    public function getDocumentCategories()
    {
        return $this->sendGetRequest('get-document-categories?token='.$this->economicRackbeatApiToken);
    }

    public function getDocument(int $documentId)
    {
        return $this->sendGetRequest('get-document?token='.$this->economicRackbeatApiToken.'&documentId='.$documentId);
    }

    public function getUnprocessedDocuments()
    {
        return $this->sendGetRequest('get-unprocessed-documents?token='.$this->economicRackbeatApiToken);
    }

    public function getDocumentsByCategory(int $categoryId)
    {
        return $this->sendGetRequest('get-documents-by-category?token='.$this->economicRackbeatApiToken. '&categoryId='.$categoryId);
    }

    public function bookAndSendInformation(int $draftId)
    {
        return $this->sendGetRequest('book-and-send-information?token='.$this->economicRackbeatApiToken. '&draftId='.$draftId);
    }

    public function attachDocumentToJournal($rackbeatAttachDocumentToJournalRequest)
    {
        return $this->sendPostRequest(
            'attach-document-to-journal?token='.$this->economicRackbeatApiToken, 
            $rackbeatAttachDocumentToJournalRequest
        );
    }

    public function bookJournal($rackbeatBookJournalRequest)
    {
        return $this->sendPostRequest(
            'book-journal?token='.$this->economicRackbeatApiToken, 
            $rackbeatBookJournalRequest
        );
    }

    public function bookAndSend($rackbeatBookAndSendRequest)
    {
        return $this->sendPostRequest(
            'book-and-send?token='.$this->economicRackbeatApiToken,
            $rackbeatBookAndSendRequest
        );
    }

    private function sendGetRequest($endpointUri)
    {
        return $response = json_decode(
            Http::withHeaders([
                'X-Signature'           => $this->getSignature(),
                'Content-Type'          => 'application/json',
            ])->get($this->basePath.$endpointUri)
        );
    }

    private function sendPostRequest($endpointUri, $payload)
    {
        return $response = json_decode(
            Http::withHeaders([
                'X-Signature'           => $this->getSignature($payload),
                'Content-Type'          => 'application/json',
            ])->post($this->basePath.$endpointUri)
        );
    }

    private function getSignature($data = "")
    {
        $private_key = "";

        $binary_signature = "";

        openssl_sign($data, $binary_signature, $private_key, OPENSSL_ALGO_SHA256);
        
        $signature = base64_encode($binary_signature);

        return $signature;
    }
}