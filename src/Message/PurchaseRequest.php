<?php

namespace Omnipay\Nestpay\Message;

class PurchaseRequest extends AbstractPayment
{
    protected string $transactionType = 'Auth';
}
