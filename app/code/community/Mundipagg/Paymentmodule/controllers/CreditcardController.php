<?php

require_once Mage::getBaseDir('lib') . '/autoload.php';

use MundiAPILib\MundiAPIClient;

class Mundipagg_Paymentmodule_CreditcardController extends Mage_Core_Controller_Front_Action
{
    public function processPaymentAction()
    {
        echo 'credit card';
    }
}
