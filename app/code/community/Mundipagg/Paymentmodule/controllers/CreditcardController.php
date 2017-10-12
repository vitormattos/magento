<?php

require_once Mage::getBaseDir('lib') . '/autoload.php';

use MundiAPILib\MundiAPIClient;

class Mundipagg_Paymentmodule_CreditcardController extends Mage_Core_Controller_Front_Action
{
    public function processPaymentAction()
    {
        $order = Mage::getModel('paymentmodule/api_order');

        $paymentInfo = new Varien_Object();

        $paymentInfo->setItemsInfo($this->getItemsInformation());
        $paymentInfo->setCustomerInfo($this->getCustomerInformation());
        $paymentInfo->setPaymentInfo($this->getPaymentInformation());
        $paymentInfo->setMetaInfo(Mage::helper('paymentmodule/data')->getMetaData());

        try {
            $result = $order->createCreditCardPayment($paymentInfo);
            $this->handleSuccessCreditCardTransaction($result);
        } catch (\Exception $e){
            // @todo log exception here
            // @todo redirect user to
        }
    }

    private function handleSuccessCreditCardTransaction($resultTransaction)
    {

    }
}
