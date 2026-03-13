<?php

namespace Omnipay\Nestpay\Message;

class AuthorizeRequest extends AbstractPayment
{
    protected string $transactionType = 'PreAuth';
}
