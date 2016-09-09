<?php

namespace Omnipay\Nestpay\Message;

class PurchaseRequest extends AbstractPayment
{
    public function getData()
    {
        $this->transactionType = 'Auth';
        return parent::getData();
    }

}
