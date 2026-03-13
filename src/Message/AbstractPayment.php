<?php

namespace Omnipay\Nestpay\Message;

use Omnipay\Common\Exception\InvalidCreditCardException;

abstract class AbstractPayment extends AbstractRequest
{
    protected string $transactionType = '';

    protected array $endpoints = [
        'isbank'      => 'https://spos.isbank.com.tr/servlet/est3Dgate',
        'akbank'      => 'https://www.sanalakpos.com/servlet/est3Dgate',
        'finansbank'  => 'https://www.fbwebpos.com/servlet/est3Dgate',
        'halkbank'    => 'https://sanalpos.halkbank.com.tr/servlet/est3Dgate',
        'anadolubank' => 'https://anadolusanalpos.est.com.tr/servlet/est3Dgate',
        'test'        => 'https://entegrasyon.asseco-see.com.tr/fim/est3Dgate',
        'cardplus'    => 'https://sanalpos.card-plus.net/servlet/est3Dgate',
    ];

    protected array $allowedCardBrands = [
        'visa'       => 1,
        'mastercard' => 2,
    ];

    public function getData(): array
    {
        $this->validate('amount', 'card');

        $cardBrand = $this->getCard()->getBrand();
        if (!array_key_exists($cardBrand, $this->allowedCardBrands)) {
            throw new InvalidCreditCardException('Kart geçerli değil, sadece Visa ya da MasterCard kullanılabilir');
        }

        $installment = $this->getInstallment() > 0 ? (string) $this->getInstallment() : '';

        $data = [];
        $data['pan']                          = $this->getCard()->getNumber();
        $data['cv2']                          = $this->getCard()->getCvv();
        $data['Ecom_Payment_Card_ExpDate_Year']  = $this->getCard()->getExpiryDate('y');
        $data['Ecom_Payment_Card_ExpDate_Month'] = $this->getCard()->getExpiryDate('m');
        $data['cardType']                     = $this->allowedCardBrands[$cardBrand];

        $data['clientid']    = $this->getClientId();
        $data['oid']         = $this->getOrderId();
        $data['amount']      = $this->getAmount();
        $data['currency']    = $this->getCurrencyNumeric();
        $data['okUrl']       = $this->getReturnUrl();
        $data['failUrl']     = $this->getCancelUrl();
        $data['storetype']   = '3d_pay';
        $data['rnd']         = (string) time();
        $data['firmaadi']    = $this->getFirmName();
        $data['Faturafirma'] = $this->getBillName();
        $data['tismi']       = $this->getDeliveryName();
        $data['islemtipi']   = $this->transactionType;
        $data['taksit']      = $installment;

        $signature = $data['clientid']
            . $data['oid']
            . $data['amount']
            . $data['okUrl']
            . $data['failUrl']
            . $data['islemtipi']
            . $data['taksit']
            . $data['rnd']
            . $this->getStoreKey();

        $data['hash'] = base64_encode(pack('H*', sha1($signature)));

        return $data;
    }

    public function sendData($data): PaymentResponse
    {
        return $this->response = new PaymentResponse($this, $data);
    }
}
