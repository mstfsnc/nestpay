<?php

namespace Omnipay\Nestpay\Message;

use Omnipay\Common\Exception\InvalidCreditCardException;

abstract class AbstractPayment extends AbstractRequest
{
    protected $transactionType;

    protected $endpoints = [
        'isbank' => 'https://vpos.isbank.co.uk/fim/est3Dgate',
        'akbank' => 'https://www.sanalakpos.com/servlet/est3Dgate',
        'finansbank' => 'https://www.fbwebpos.com/servlet/est3Dgate',
        'halkbank' => 'https://sanalpos.halkbank.com.tr/servlet/est3Dgate',
        'anadolubank' => 'https://anadolusanalpos.est.com.tr/servlet/est3Dgate',
        'test' => 'https://entegrasyon.asseco-see.com.tr/fim/est3Dgate',
        'cardplus' => 'https://sanalpos.card-plus.net/servlet/est3Dgate',
    ];

    protected $allowedCardBrands = [
        'visa' => 1,
        'mastercard' => 2
    ];

    public function getData()
    {
        $this->validate('amount', 'card');

        $cardBrand = $this->getCard()->getBrand();
        if (!array_key_exists($cardBrand, $this->allowedCardBrands)) {
            throw new InvalidCreditCardException('Kart geçerli değil, sadece Visa ya da MasterCard kullanılabilir');
        } 

        $data = array();
        $data['pan'] = $this->getCard()->getNumber();
        $data['cv2'] = $this->getCard()->getCvv();
        $data['Ecom_Payment_Card_ExpDate_Year'] = $this->getCard()->getExpiryDate('y');
        $data['Ecom_Payment_Card_ExpDate_Month'] = $this->getCard()->getExpiryDate('m');
        $data['cardType'] = $this->allowedCardBrands[$cardBrand];

        $data['clientid'] = $this->getClientId();
        $data['oid'] = $this->getOrderId();
        $data['amount'] = $this->getAmount();
        $data['currency'] = $this->getCurrencyNumeric();
        $data['okUrl'] = $this->getReturnUrl();
        $data['failUrl'] = $this->getCancelUrl();
        $data['storetype'] = $this->getStoreType();
        $data['rnd'] = time();
        $data['firmaadi'] = $this->getFirmName();
        $data['Faturafirma'] = $this->getBillName();
        $data['tismi'] = $this->getDeliveryName();
        $data['islemtipi'] = $this->transactionType;
        
        $data["Email"] = $this->getEmail();
        $data["Fadres"] = $this->getFadres();
        $data["Fadres2"] = $this->getFadres2();
        $data["Filce"] = $this->getFilce();
        $data["Fil"] = $this->getFil();
        $data["Fpostakodu"] = $this->getFpostakodu();
        $data["Fulkekodu"] = $this->getFulkekodu();
        $data["Fulke"] = $this->getFulke();
        
        $data["NakliyeFirma"] = $this->getNakliyeFirma();
        $data["tismi"] = $this->getTismi();
        $data["tadres"] = $this->getTadres();
        $data["tadres2"] = $this->getTadres2();
        $data["tilce"] = $this->getTilce();
        $data["til"] = $this->getTil();
        $data["tpostakodu"] = $this->getTpostakodu();
        $data["tulkekod"] = $this->getTulkekod();
        $data["tulke"] = $this->getTulke();
        $data["tel"] = $this->getTel();
        $data["lang"] = $this->getLang();
        $data["shipAddrState"] = $this->getShipAddrState();
        $data['taksit'] = null;
        if ($installment = $this->getInstallment()) {
            $data['taksit'] = $installment;
        }

        $signature =    $data['clientid'].
                        $data['oid'].
                        $data['amount'].
                        $data['okUrl'].
                        $data['failUrl'].
                        $data['islemtipi'].
                        $data['taksit'].
                        $data['rnd'].
                        $this->getStoreKey();

        $data['hash'] = base64_encode(pack('H*', sha1($signature)));
        return $data;
    }

    public function sendData($data)
    {
        return $this->response = new PaymentResponse($this, $data);
    }

    public function getStoreType(){
        return $this->getParameter('storetype');
    }
    
    public function setStoreType($value){
    	return $this->setParameter('storetype', $value);
    }

    public function getEmail(){
        return $this->getParameter('Email');
    }
    
    public function setEmail($value){
    	return $this->setParameter('Email', $value);
    }

    public function getFadres(){
        return $this->getParameter('Fadres');
    }
    
    public function setFadres($value){
    	return $this->setParameter('Fadres', $value);
    }

    public function getFadres2(){
        return $this->getParameter('Fadres2');
    }
    
    public function setFadres2($value){
    	return $this->setParameter('Fadres2', $value);
    }

    public function getFilce(){
        return $this->getParameter('Filce');
    }
    
    public function setFilce($value){
    	return $this->setParameter('Filce', $value);
    }

    public function getFil(){
        return $this->getParameter('Fil');
    }
    
    public function setFil($value){
    	return $this->setParameter('Fil', $value);
    }

    public function getFpostakodu(){
        return $this->getParameter('Fpostakodu');
    }
    
    public function setFpostakodu($value){
    	return $this->setParameter('Fpostakodu', $value);
    }

    public function getFulkekodu(){
        return $this->getParameter('Fulkekodu');
    }
    
    public function setFulkekodu($value){
    	return $this->setParameter('Fulkekodu', $value);
    }

    public function getFulke(){
        return $this->getParameter('Fulke');
    }
    
    public function setFulke($value){
    	return $this->setParameter('Fulke', $value);
    }

    public function getNakliyeFirma(){
        return $this->getParameter('NakliyeFirma');
    }
    
    public function setNakliyeFirma($value){
    	return $this->setParameter('NakliyeFirma', $value);
    }

    public function getTismi(){
        return $this->getParameter('tismi');
    }
    
    public function setTismi($value){
    	return $this->setParameter('tismi', $value);
    }

    public function getTadres(){
        return $this->getParameter('tadres');
    }
    
    public function setTadres($value){
    	return $this->setParameter('tadres', $value);
    }

    public function getTadres2(){
        return $this->getParameter('tadres2');
    }
    
    public function setTadres2($value){
    	return $this->setParameter('tadres2', $value);
    }

    public function getTilce(){
        return $this->getParameter('tilce');
    }
    
    public function setTilce($value){
    	return $this->setParameter('tilce', $value);
    }

    public function getTil(){
        return $this->getParameter('til');
    }
    
    public function setTil($value){
    	return $this->setParameter('til', $value);
    }

    public function getTpostakodu(){
        return $this->getParameter('tpostakodu');
    }
    
    public function setTpostakodu($value){
    	return $this->setParameter('tpostakodu', $value);
    }

    public function getTulkekod(){
        return $this->getParameter('tulkekod');
    }
    
    public function setTulkekod($value){
    	return $this->setParameter('tulkekod', $value);
    }

    public function getTulke(){
        return $this->getParameter('tulke');
    }
    
    public function setTulke($value){
    	return $this->setParameter('tulke', $value);
    }

    public function getTel(){
        return $this->getParameter('tel');
    }
    
    public function setTel($value){
    	return $this->setParameter('tel', $value);
    }

    public function getLang(){
        return $this->getParameter('lang');
    }
    
    public function setLang($value){
    	return $this->setParameter('lang', $value);
    }
    
    public function getShipAddrState(){
        return $this->getParameter('shipAddrState');
    }
   
    public function setShipAddrState($value){
        return $this->setParameter('shipAddrState', $value);
    }
}
