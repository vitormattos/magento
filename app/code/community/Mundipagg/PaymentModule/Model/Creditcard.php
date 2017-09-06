<?php

class Mundipagg_PaymentModule_Model_Creditcard extends Mage_Payment_Block_Form
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('mundipagg/form/creditcard.phtml');
    }
}
