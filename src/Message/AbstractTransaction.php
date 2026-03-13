<?php

namespace Omnipay\Nestpay\Message;

use DOMDocument;

abstract class AbstractTransaction extends AbstractRequest
{
    protected string $type = '';

    protected array $endpoints = [
        'isbank'      => 'https://spos.isbank.com.tr/servlet/cc5ApiServer',
        'akbank'      => 'https://www.sanalakpos.com/servlet/cc5ApiServer',
        'finansbank'  => 'https://www.fbwebpos.com/servlet/cc5ApiServer',
        'halkbank'    => 'https://sanalpos.halkbank.com.tr/servlet/cc5ApiServer',
        'anadolubank' => 'https://anadolusanalpos.est.com.tr/servlet/cc5ApiServer',
        'test'        => 'https://entegrasyon.asseco-see.com.tr/servlet/cc5ApiServer',
    ];

    public function getData(): array
    {
        return [
            'Name'     => $this->getUsername(),
            'Password' => $this->getPassword(),
            'ClientId' => $this->getClientId(),
            'Type'     => $this->type,
            'OrderId'  => $this->getOrderId(),
        ];
    }

    public function sendData($data): TransactionResponse
    {
        $document = new DOMDocument('1.0', 'UTF-8');

        $root = $document->createElement('CC5Request');
        foreach ($data as $id => $value) {
            $root->appendChild($document->createElement($id, (string) $value));
        }
        $document->appendChild($root);

        $httpResponse = $this->httpClient->request(
            'POST',
            $this->getEndpoint(),
            ['Content-Type' => 'text/xml; charset=UTF-8'],
            $document->saveXML()
        );

        return $this->response = new TransactionResponse($this, (string) $httpResponse->getBody());
    }
}
