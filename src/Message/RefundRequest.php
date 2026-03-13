<?php

namespace Omnipay\Nestpay\Message;

class RefundRequest extends AbstractTransaction
{
    protected string $type = 'Credit';
}
