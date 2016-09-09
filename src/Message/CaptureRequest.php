<?php

namespace Omnipay\Nestpay\Message;

class CaptureRequest extends AbstractTransaction
{

    public function getData()
    {
        $this->type = 'PostAuth';
        return parent::getData();
    }

}
