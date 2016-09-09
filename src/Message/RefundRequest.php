<?php

namespace Omnipay\Nestpay\Message;

class RefundRequest extends AbstractTransaction
{
    public function getData()
    {
        $this->type = 'Credit';
        return parent::getData();
    }

}
