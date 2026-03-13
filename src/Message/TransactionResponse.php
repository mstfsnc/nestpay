<?php

namespace Omnipay\Nestpay\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Common\Exception\InvalidResponseException;

class TransactionResponse extends AbstractResponse
{
    public function __construct(RequestInterface $request, $data)
    {
        $this->request = $request;

        $xml = simplexml_load_string((string) $data);
        if ($xml === false) {
            throw new InvalidResponseException('Bankadan geçersiz yanıt alındı');
        }

        $this->data = (array) $xml;
    }

    public function isSuccessful(): bool
    {
        if (isset($this->data['ProcReturnCode'])) {
            if ((string) $this->data['ProcReturnCode'] === '00') {
                return true;
            }
        }

        return isset($this->data['Response']) && $this->data['Response'] === 'Approved';
    }

    public function getMessage(): ?string
    {
        return $this->data['ErrMsg'] ?? null;
    }

    public function getTransactionId(): ?string
    {
        return $this->data['TransId'] ?? null;
    }

    public function getTransactionReference(): ?string
    {
        return $this->data['HostRefNum'] ?? null;
    }
}
