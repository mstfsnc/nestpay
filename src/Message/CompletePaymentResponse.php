<?php

namespace Omnipay\Nestpay\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Common\Exception\InvalidResponseException;

class CompletePaymentResponse extends AbstractResponse
{
    public function __construct(RequestInterface $request, $data)
    {
        $this->request = $request;
        $this->data = $data;

        if (!$this->signHash()) {
            throw new InvalidResponseException('Sayısal İmza Doğrulanmadı');
        }
    }

    public function isSuccessful(): bool
    {
        return in_array($this->data['mdStatus'] ?? null, [1, 2, 3, 4], true)
            && ($this->data['Response'] ?? '') === 'Approved';
    }

    public function getMessage(): ?string
    {
        return $this->data['ErrMsg'] ?? $this->data['mdErrorMsg'] ?? null;
    }

    public function getTransactionId(): ?string
    {
        return $this->data['TransId'] ?? null;
    }

    public function getTransactionReference(): ?string
    {
        return $this->data['HostRefNum'] ?? null;
    }

    public function getAmount(): ?string
    {
        return $this->data['amount'] ?? null;
    }

    public function getCurrency(): ?string
    {
        return $this->data['currency'] ?? null;
    }

    public function getOrderId(): ?string
    {
        return $this->data['ReturnOid'] ?? null;
    }

    private function signHash(): bool
    {
        if (!isset($this->data['HASHPARAMS'], $this->data['HASHPARAMSVAL'], $this->data['HASH'])) {
            return false;
        }

        $hashParams = explode(':', $this->data['HASHPARAMS']);
        $signature = '';
        foreach ($hashParams as $parameter) {
            if (isset($this->data[$parameter])) {
                $signature .= $this->data[$parameter];
            }
        }

        $generateHash = base64_encode(pack('H*', sha1($signature . $this->request->getStoreKey())));

        if ($signature !== $this->data['HASHPARAMSVAL'] || $generateHash !== $this->data['HASH']) {
            return false;
        }

        return true;
    }
}
