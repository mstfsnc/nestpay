<?php

namespace Omnipay\Nestpay\Message;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{

    protected $endpoints = [];

    public function getBank () {
        return $this->getParameter('bank');
    }

    public function setBank ($value) {
        return $this->setParameter('bank', $value);
    }

    public function getUsername () {
        return $this->getParameter('username');
    }

    public function setUsername ($value) {
        return $this->setParameter('username', $value);
    }

    public function getPassword () {
        return $this->getParameter('password');
    }

    public function setPassword ($value) {
        return $this->setParameter('password', $value);
    }
    
    public function getClientId () {
        return $this->getParameter('clientId');
    }

    public function setClientId ($value) {
        return $this->setParameter('clientId', $value);
    }

    public function getStoreKey () {
        return $this->getParameter('storeKey');
    }

    public function setStoreKey ($value) {
        return $this->setParameter('storeKey', $value);
    }

    public function getOrderId () {
        return $this->getParameter('orderId');
    }

    public function setOrderId ($value) {
        return $this->setParameter('orderId', $value);
    }

    public function getFirmName() {
        return $this->getParameter('firmName');
    }

    public function setFirmName ($value) {
        return $this->setParameter('firmName', $value);
    }

    public function getInstallment () {
        return $this->getParameter('installment');
    }

    public function setInstallment($value) {
        return $this->setParameter('installment', $value);
    }

    public function getEndpoint()
    {
        $gateway = $this->getBank();
        if (!array_key_exists($gateway, $this->endpoints)) {
            throw new \Exception('Banka geçerli değil');
        }
        return $this->endpoints[$gateway];
    }

}
