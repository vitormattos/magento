<?php

class Mundipagg_Paymentmodule_BoletoController extends Mage_Core_Controller_Front_Action
{
    public function processPaymentAction()
    {
        $order = Mage::getModel('paymentmodule/api_order');

        $paymentInfo = new Varien_Object();

        $paymentInfo->setItemsInfo($this->getItemsInformation());
//        $paymentInfo->setCustomerInfo($this->getCustomerInformation());
//        $paymentInfo->setPaymentInfo($this->getPaymentInformation());
//        $paymentInfo->setMetaInfo(Mage::helper('paymentmodule/data')->getMetaData());

        $result = $order->createBoletoPayment($paymentInfo);
    }

    private function getItemsInformation()
    {



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
