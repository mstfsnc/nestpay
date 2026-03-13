<?php

namespace Omnipay\Nestpay\Message;

class CaptureRequest extends AbstractTransaction
{
    protected string $type = 'PostAuth';
}
