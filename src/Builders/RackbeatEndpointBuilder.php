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
        return $this->sendGetRequest('get-document-categories?token='.$this->$economicRackbeatApiToken);
    }

    public function getDocument(int $documentId)
    {
        return $this->sendGetRequest('get-document?token='.$this->$economicRackbeatApiToken.'&documentId='.$documentId);
    }

    public function getUnprocessedDocuments()
    {
        return $this->sendGetRequest('get-unprocessed-documents?token='.$this->$economicRackbeatApiToken);
    }

    public function getDocumentsByCategory(int $categoryId)
    {
        return $this->sendGetRequest('get-documents-by-category?token='.$this->$economicRackbeatApiToken. '&categoryId'.$categoryId);
    }

    public function attachDocumentToJournal($rackbeatAttachDocumentToJournalRequest)
    {
        return $this->sendPostRequest(
            'attach-document-to-journal?token='.$this->$economicRackbeatApiToken, 
            $rackbeatAttachDocumentToJournalRequest
        );
    }

    public function bookJournal($rackbeatBookJournalRequest)
    {
        return $this->sendPostRequest(
            'book-journal?token='.$this->$economicRackbeatApiToken, 
            $rackbeatBookJournalRequest
        );
    }

    public function bookAndSendInformation(int $draftId)
    {
        return $this->sendGetRequest('book-and-send-information?token='.$this->$economicRackbeatApiToken. '&draftId='.$draftId);
    }

    public function bookAndSend($rackbeatBookAndSendRequest)
    {
        return $this->sendPostRequest(
            'book-and-send?token='.$this->$economicRackbeatApiToken,
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
        $private_key = "-----BEGIN RSA PRIVATE KEY-----\r\nMIIEogIBAAKCAQEAtptt7yih8Q1IUpAQBhXlyQoVJjwqKZj5DQjZMyujbjt2MbvK\r\nYkfyMpsRBk4VisdIUL2lqagyUTzumMWgRzchH7OOTs4THm91IQukOv5JaJ+SCKvu\r\n/xusduOhez0dcTLjrubiDwUUhvaTHqH75uPXUWNvz7H+bP4U49lKamz9vx0i7mWB\r\nr5WhORUkfIrX985BShw9TPWh53C00elqxa+DhPo4SCiZqfNy5WTkXebleY6WU0yr\r\nUJCGx6/S1tBHwzrU2AT9Ta3h1SWiK5aPvdn7NfB4RU0gzoyFGgqUsis0b6oKe/y8\r\nTA2n5PKzyF1ZpOJk63fHtyUxIMfFnP9X5oO3XQIDAQABAoIBAAHurB+jQO9xkgnZ\r\nn2nJEojpk+a3LUUKatxB8zZw6EZS18HX+GDI3R2++VOlQOIakL/V+epNLtcgO3Af\r\naz5FrZKNzlw0Hwyr5kPmwSKkrTcvtRZlZ16Itu79IqjQsT6Q6Mrhg5PgHGL/OfhR\r\ng35ie9VPJZA/lG8n0yXEF17/70F182S/7L0KID0I3izuFHA5z/oEuGUNbsiLocne\r\nHD2DTjKXF6EYpVXFrL5tCHVNFk7b2ZKmGAV2YYb6yEhuY1dvKQcQAihtCwAVkNQW\r\nULOl8dCfui4I5wXotZoCYbGMuF2savs7Q/TNH0zIRJ8nfc0juAu6JJF3XekIP4tx\r\nJXhGursCgYEA2GEQbn7eyqJq73UKA4brptc1QcS4S4ckGw+Cvx8ipb4qQu/jISEU\r\nqaeqLNiQmWeuyCn/S+qcu51RLDPrNpXBMM2WSMMtPgZJdZuZytoSq2q+MBiDvLtB\r\nXN6R9DuZ24rGN+EiLar4BQikCLDCe4+4Zfxkkut/ZRgnXlkMiaLRmBsCgYEA2AtG\r\n3gwI3qZ/raD42X8BKtiHOOTF+wWFgoDqahUXZsROTvoJ4Td4hyCmRbOlzpTcgh5Z\r\n3FUCAmdZM5HZ5GR6BiZ5VDgcE20yleVkBbALbpeAPkvDpdos4jL8tGwUPT9o11k9\r\navt+zeaeQP4Xp2a8qVAW+SOHBOs4pWVJCG7P1ecCgYAQr7uSqdoIimnwuXfiOb9m\r\niGYlAkSsHmncZF/S2VXUrkuYCePcJC7xvmpTNwg/rE1ARmzXr+oSVdlyrTZQaVAS\r\nsWgLiHGuvNFhbnR3vkV+TqcIEnvmTBKIVOmwigAdfCA5IvV9zBeAW+A6g1ccLEMu\r\nKj6fTeXvJ+OxVPCwlIvRTQKBgCKEkrsRgy1HvuiX6oqdjyswU1KUwskblbxHKqzu\r\nV8HUpYpays9QFJLKdaZ3UIuUHzMu9D6O2nZV2tuxdvXV0+U9qm75VAsKjGWEtBlw\r\nijMOQ7AwXL8X/8nYSaXuCsHKas7VdEmuixEMwsYxksftU0FeCX2e3oi7qF5Ms4GE\r\navKLAoGAZOnoMm75d5cPjgmmq1eMVvUQR9gHhtuTofrXDDwxrwX0imAqwDYTUDzI\r\nQjsxaxQqKHpenYy+yc1miKS3UbkY4ek+4lQRRrperJN2zWM4grcGhTP2YdRjbQ4Z\r\nIWBXk5jqLn3EvDtwgPFXum/+BwcgiJWz00yivNP3WOpifCT4Qr0=\r\n-----END RSA PRIVATE KEY-----";

        $binary_signature = "";

        openssl_sign($data, $binary_signature, $private_key, OPENSSL_ALGO_SHA256);
        
        $signature = base64_encode($binary_signature);

        return $signature;
    }
}