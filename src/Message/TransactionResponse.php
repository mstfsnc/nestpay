<?php

namespace Omnipay\Nestpay\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Common\Exception\InvalidResponseException;

class TransactionResponse extends AbstractResponse
{

    public function __construct(RequestInterface $request, $data) {
        $this->request = $request;
        try {
            $this->data = (array) simplexml_load_string($data);
        } catch (\Exception $ex) {
            throw new InvalidResponseException();
        }
    }

    public function isSuccessful() {
        if (isset($this->data["ProcReturnCode"])) {
            return (string) $this->data["ProcReturnCode"] === '00' || $this->data["Response"] === 'Approved';
        }
        return false;
    }

    public function getMessage()
    {
        return $this->data['ErrMsg'];
    }

    public function getTransactionId()
    {
        return $this->data['TransId'];
    }

    public function getTransactionReference()
    {
        return $this->data['HostRefNum'];
    }

}
