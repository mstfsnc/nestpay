<?php

namespace Omnipay\Nestpay\Message;

class AuthorizeRequest extends AbstractPayment
{
    public function getData()
    {
        $this->transactionType = 'PreAuth';
        return parent::getData();
    }
    
}
