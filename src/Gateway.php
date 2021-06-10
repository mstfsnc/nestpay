<?php

namespace Omnipay\Nestpay;

use Omnipay\Common\AbstractGateway;

class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Nestpay';
    }

    public function getDefaultParameters()
    {
        return array(
            'bank' => '',
            'username' => '',
            'password' => '',
            'clientId' => '',
            'orderid' => '',
            'storeKey' => '',
            'firmName' => '',
            'transactionType' => 'Auth',
            'installment' => 0,
            'testMode' => false,
            'Faturafirma' => '',
        );
    }

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

    public function getFirmName() {
        return $this->getParameter('firmName');
    }

    public function setFirmName ($value) {
        return $this->setParameter('firmName', $value);
    }

    public function getBillName() {
        return $this->getParameter('Faturafirma');
    }

    public function setBillName ($value) {
        return $this->setParameter('Faturafirma', $value);
    }

    public function authorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Nestpay\Message\AuthorizeRequest', $parameters);
    }

    public function completeAuthorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Nestpay\Message\CompletePaymentRequest', $parameters);
    }

    public function capture(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Nestpay\Message\CaptureRequest', $parameters);
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Nestpay\Message\PurchaseRequest', $parameters);
    }

    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Nestpay\Message\CompletePaymentRequest', $parameters);
    }

    public function void(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Nestpay\Message\VoidRequest', $parameters);
    }

    public function refund(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Nestpay\Message\RefundRequest', $parameters);
    }

}
