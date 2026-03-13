<?php

namespace Omnipay\Nestpay;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\RequestInterface;

class Gateway extends AbstractGateway
{
    public function getName(): string
    {
        return 'Nestpay';
    }

    public function getDefaultParameters(): array
    {
        return [
            'bank' => '',
            'username' => '',
            'password' => '',
            'clientId' => '',
            'orderId' => '',
            'storeKey' => '',
            'firmName' => '',
            'transactionType' => 'Auth',
            'installment' => 0,
            'testMode' => false,
            'billName' => '',
            'deliveryName' => '',
        ];
    }

    public function getBank(): ?string
    {
        return $this->getParameter('bank');
    }

    public function setBank(string $value): self
    {
        return $this->setParameter('bank', $value);
    }

    public function getUsername(): ?string
    {
        return $this->getParameter('username');
    }

    public function setUsername(string $value): self
    {
        return $this->setParameter('username', $value);
    }

    public function getPassword(): ?string
    {
        return $this->getParameter('password');
    }

    public function setPassword(string $value): self
    {
        return $this->setParameter('password', $value);
    }

    public function getClientId(): ?string
    {
        return $this->getParameter('clientId');
    }

    public function setClientId(string $value): self
    {
        return $this->setParameter('clientId', $value);
    }

    public function getStoreKey(): ?string
    {
        return $this->getParameter('storeKey');
    }

    public function setStoreKey(string $value): self
    {
        return $this->setParameter('storeKey', $value);
    }

    public function getFirmName(): ?string
    {
        return $this->getParameter('firmName');
    }

    public function setFirmName(string $value): self
    {
        return $this->setParameter('firmName', $value);
    }

    public function getBillName(): ?string
    {
        return $this->getParameter('billName');
    }

    public function setBillName(string $value): self
    {
        return $this->setParameter('billName', $value);
    }

    public function getDeliveryName(): ?string
    {
        return $this->getParameter('deliveryName');
    }

    public function setDeliveryName(string $value): self
    {
        return $this->setParameter('deliveryName', $value);
    }

    public function authorize(array $parameters = []): RequestInterface
    {
        return $this->createRequest('\Omnipay\Nestpay\Message\AuthorizeRequest', $parameters);
    }

    public function completeAuthorize(array $parameters = []): RequestInterface
    {
        return $this->createRequest('\Omnipay\Nestpay\Message\CompletePaymentRequest', $parameters);
    }

    public function capture(array $parameters = []): RequestInterface
    {
        return $this->createRequest('\Omnipay\Nestpay\Message\CaptureRequest', $parameters);
    }

    public function purchase(array $parameters = []): RequestInterface
    {
        return $this->createRequest('\Omnipay\Nestpay\Message\PurchaseRequest', $parameters);
    }

    public function completePurchase(array $parameters = []): RequestInterface
    {
        return $this->createRequest('\Omnipay\Nestpay\Message\CompletePaymentRequest', $parameters);
    }

    public function void(array $parameters = []): RequestInterface
    {
        return $this->createRequest('\Omnipay\Nestpay\Message\VoidRequest', $parameters);
    }

    public function refund(array $parameters = []): RequestInterface
    {
        return $this->createRequest('\Omnipay\Nestpay\Message\RefundRequest', $parameters);
    }
}
