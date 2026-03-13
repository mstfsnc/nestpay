<?php

namespace Omnipay\Nestpay\Message;

class VoidRequest extends AbstractTransaction
{
    protected string $type = 'Void';
}
