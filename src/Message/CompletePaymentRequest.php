<?php

namespace Omnipay\Nestpay\Message;

class CompletePaymentRequest extends AbstractPayment
{
    public function getData(): array
    {
        return $this->httpRequest->request->all();
    }

    public function sendData($data): CompletePaymentResponse
    {
        return $this->response = new CompletePaymentResponse($this, $data);
    }
}
