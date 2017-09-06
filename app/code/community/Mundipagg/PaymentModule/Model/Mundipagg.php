<?php

class Mundipagg_PaymentModule_Model_Payment extends Mage_Payment_Model_Method_Abstract
{
    public function assignData($data)
    {
        return $this;
    }

    public function validate()
    {
        return $this;
    }

    public function getOrderPlaceRedirectUrl()
    {
    }
}
