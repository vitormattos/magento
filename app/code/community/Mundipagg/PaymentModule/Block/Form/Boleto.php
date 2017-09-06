<?php

class Mundipagg_PaymentModule_Block_Form_Boleto extends Mage_Payment_Block_Form
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('mundipagg/paymentmodule/form/boleto.phtml');
    }
}
