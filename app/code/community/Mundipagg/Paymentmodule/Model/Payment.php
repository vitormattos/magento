<?php


class Mundipagg_Paymentmodule_Model_Payment extends Mage_Sales_Model_Order_Payment
{
    public function capture($invoice)
    {
        $a = 1;
        return parent::capture($invoice);
    }
}
