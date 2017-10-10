<?php

require_once Mage::getBaseDir('lib') . '/autoload.php';

use MundiAPILib\MundiAPIClient;

class Mundipagg_Paymentmodule_BoletoController extends Mage_Core_Controller_Front_Action
{
    public function processPaymentAction()
    {
        $boletoConfig = Mage::getModel('paymentmodule/config_boleto');
        echo $boletoConfig->isEnabled();


//        $paymentInfo = new Varien_Object();
//
//        $paymentInfo->setItemsInfo($this->getItemsInformation());
//        $paymentInfo->setCustomerInfo($this->getCustomerInformation());
//        $paymentInfo->setPaymentInfo($this->getPaymentInformation());
//
//        $order = Mage::getModel('paymentmodule/order');
    }

    private function getItemsInformation()
    {
        $session = Mage::getSingleton('checkout/session');
        $order = Mage::getModel('sales/order');

        $orderId = $session->getLastOrderId();
        $orderData = $order->load($orderId);

        return $orderData->getItemsCollection();
    }

    private function getCustomerInformation()
    {
        $customerId = Mage::getSingleton('customer/session')->getCustomerId();
        $customer = Mage::getModel('paymentmodule/customer');

        // customer exist here and at mundipagg
        if ($customer->hasId($customerId)) {
            return $customer->getMundipaggCustomerId($customerId);
        }

        // customer only exist here, create
        $customer->createMundipaggCustomer($customerId);

        return $customer->getMundipaggCustomerId($customerId);
    }

    private function getPaymentInformation()
    {
        $payment = new Varien_Object();
        $payment->setPaymentMethod('boleto');
    }
}
