<?php

namespace Omnipay\Nestpay\Message;

class CompletePaymentRequest extends AbstractPayment
{

	public function getData()
    {
        return $this->httpRequest->request->all();
    }

    public function sendData($data)
    {
        return $this->response = new CompletePaymentResponse($this, $data);
    }

}