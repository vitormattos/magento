<?php

class Mundipagg_Paymentmodule_BoletoController extends Mage_Core_Controller_Front_Action
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
            $result = $order->createBoletoPayment($paymentInfo);
            $this->handleSuccessBoletoTransaction($result);
        } catch (\Exception $e){
            // @todo log exception here
            // @todo redirect user to
        }
    }

    private function handleSuccessBoletoTransaction($resultTransaction)
    {

    }

    /**
     * Provide ordered items information
     *
     * @return array
     */
    private function getItemsInformation()
    {
        $items = array();

        $orderId = Mage::getSingleton('checkout/session')->getLastOrderId();
        $order = Mage::getModel("sales/order")->load($orderId);

        foreach ($order->getAllItems() as $item) {
            $items[] = array(
                // @fixme don't forget multiply by 100 to get amount in cents
                // https://stackoverflow.com/questions/31178749/how-to-transform-the-magento-order-price-in-cents
                'amount' => $item->getPrice(),
                'quantity' => $item->getQtyOrdered()
            );
        }

        return $items;
    }

    /**
     * @return mixed
     */
    private function getCustomerInformation()
    {
        $customer = Mage::getSingleton('customer/session')->getCustomer();

        $information = new Varien_Object();
        $information->setName($customer->getName());
        $information->setEmail($customer->getEmail());
        $information->setDocument(null);
        $information->setType('individual');
        $information->setAddress($this->getCustomerAddressInformation());
        $information->setMetadata(null);
        $information->setPhones($this->getCustomerPhonesInformation());
        $information->setCode(
            Mage::getSingleton('customer/session')
                ->getCustomer()
                ->getId()
        );

        return $information;
    }

    private function getCustomerAddressInformation()
    {
        $orderId = Mage::getSingleton('checkout/session')->getLastOrderId();
        $order = Mage::getModel("sales/order")->load($orderId);

        $billingAddress = $order->getBillingAddress();

        $address = new Varien_Object();

        $address->setStreet($billingAddress->getStreet());
        $address->setNumber('number');
        $address->setZipCode($billingAddress->getPostcode());
        $address->setNeighborhood('bairro');
        $address->setCity($billingAddress->getCity());
        $address->setState($billingAddress->getRegion());
        $address->setCountry($billingAddress->getCountryId());
        $address->setComplement('complement');
        $address->setMetadata(null);

        return $address;
    }

    private function getCustomerPhonesInformation()
    {
        $phones = new Varien_Object();

        $phones->setCountryCode('55');
        $phones->setNumber('9999999999');
        $phones->setAreacode('21');

        return $phones;
    }

    private function getPaymentInformation()
    {
        $boletoConfig = Mage::getModel('paymentmodule/config_boleto');

        $payment = new Varien_Object();

        $payment->setPaymentMethod('boleto');
        $payment->setAmount(
            $grandTotal = Mage::getModel('checkout/session')
                ->getQuote()
                ->getGrandTotal()
        );
        $payment->setBank($boletoConfig->getBank());
        $payment->setInstructions($boletoConfig->getInstructions());
        $payment->setDueAt($boletoConfig->getDueAt());

        return $payment;
    }
}
