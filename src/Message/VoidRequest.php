<?php

namespace Omnipay\Nestpay\Message;

class VoidRequest extends AbstractTransaction
{
    public function getData()
    {
        $this->type = 'Void';
        return parent::getData();
    }

}
