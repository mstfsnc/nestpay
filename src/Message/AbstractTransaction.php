<?php

namespace Omnipay\Nestpay\Message;

use DOMDocument;

abstract class AbstractTransaction extends AbstractRequest
{

    protected $type;

    protected $endpoints = [
        'isbank' => 'https://spos.isbank.com.tr/servlet/cc5ApiServer',
        'akbank' => 'https://www.sanalakpos.com/servlet/cc5ApiServer',
        'finansbank' => 'https://www.fbwebpos.com/servlet/cc5ApiServer',
        'halkbank' => 'https://sanalpos.halkbank.com.tr/servlet/cc5ApiServer',
        'anadolubank' => 'https://anadolusanalpos.est.com.tr/servlet/cc5ApiServer',
        'test' => 'https://entegrasyon.asseco-see.com.tr/servlet/cc5ApiServer',
    ];

    public function getData()
    {
        $data['Name'] = $this->getUsername();
        $data['Password'] = $this->getPassword();
        $data['ClientId'] = $this->getClientId();
        $data['Type'] = $this->type;
        $data['OrderId'] = $this->getOrderId();
        return $data;
    }

    public function sendData($data)
    {
        $document = new DOMDocument('1.0', 'UTF-8');

        $root = $document->createElement('CC5Request');
        foreach ($data as $id => $value) {
            $root->appendChild($document->createElement($id, $value));
        }
        $document->appendChild($root);

        $headers = array(
            'Content-Type' => 'application/x-www-form-urlencoded'
        );
        $this->httpClient->setConfig(array(
            'curl.options' => array(
                'CURLOPT_SSL_VERIFYHOST' => 2,
                'CURLOPT_SSLVERSION' => 0,
                'CURLOPT_SSL_VERIFYPEER' => 0,
                'CURLOPT_RETURNTRANSFER' => 1,
                'CURLOPT_POST' => 1
            )
        ));

        $httpResponse = $this->httpClient->post($this->getEndpoint(), $headers, $document->saveXML())->send();

        return $this->response = new TransactionResponse($this, $httpResponse->getBody());
    }
}
