<?php

namespace Omnipay\Nestpay\Message;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected array $endpoints = [];

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

    public function getOrderId(): ?string
    {
        return $this->getParameter('orderId');
    }

    public function setOrderId(string $value): self
    {
        return $this->setParameter('orderId', $value);
    }

    public function getFirmName(): ?string
    {
        return $this->getParameter('firmName');
    }

    public function setFirmName(string $value): self
    {
        return $this->setParameter('firmName', $value);
    }

    public function getInstallment(): int
    {
        return (int) $this->getParameter('installment');
    }

    public function setInstallment(int $value): self
    {
        return $this->setParameter('installment', $value);
    }

    public function getDeliveryName(): ?string
    {
        return $this->getParameter('deliveryName');
    }

    public function setDeliveryName(string $value): self
    {
        return $this->setParameter('deliveryName', $value);
    }

    public function getBillName(): ?string
    {
        return $this->getParameter('billName');
    }

    public function setBillName(string $value): self
    {
        return $this->setParameter('billName', $value);
    }

    public function getEndpoint(): string
    {
        $gateway = $this->getBank();
        if ($gateway === null || !array_key_exists($gateway, $this->endpoints)) {
            throw new \InvalidArgumentException('Banka geçerli değil');
        }
        return $this->endpoints[$gateway];
    }
}
