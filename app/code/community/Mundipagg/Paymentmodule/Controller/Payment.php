<?php

class Mundipagg_Paymentmodule_Controller_Payment extends Mage_Core_Controller_Front_Action
{
    /**
     * Gather information about customer
     *
     * @return Varien_Object
     */
    protected function getCustomerInformation()
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

    /**
     * Gather information about customer's address
     *
     * @return Varien_Object
     */
    protected function getCustomerAddressInformation()
    {
        $orderId = Mage::getSingleton('checkout/session')->getLastOrderId();
        $order = Mage::getModel("sales/order")->load($orderId);

        $billingAddress = $order->getBillingAddress();

        $address = new Varien_Object();

        // @fixme I'm using this getStreet()[0] here but maybe there's a better way...
        $address->setStreet($billingAddress->getStreet()[0]);
        $address->setNumber('number');
        $address->setZipCode($billingAddress->getPostcode());
        $address->setNeighborhood('neighborhood');
        $address->setCity($billingAddress->getCity());
        $address->setState($billingAddress->getRegion());
        $address->setCountry($billingAddress->getCountryId());
        $address->setComplement('complement');
        $address->setMetadata(null);

        return $address;
    }

    /**
     * Gather information about customer's phones
     *
     * @return Varien_Object
     */
    private function getCustomerPhonesInformation()
    {
        $phones = new Varien_Object();

        // @todo it must not be hard coded
        $phones->setCountryCode('55');
        $phones->setNumber('9999999999');
        $phones->setAreacode('21');

        return $phones;
    }

    /**
     * Provide ordered items information
     *
     * @return array
     */
    protected function getItemsInformation()
    {
        $items = array();

        $orderId = Mage::getSingleton('checkout/session')->getLastOrderId();
        $order = Mage::getModel("sales/order")->load($orderId);

        foreach ($order->getAllItems() as $item) {
            $itemInfo = new Varien_Object();
            $itemInfo->setAmount(round($item->getPrice() * 100));
            $itemInfo->setQuantity((int) $item->getQtyOrdered());
            $itemInfo->setDescription('item description');

            $items[] = $itemInfo;
        }

        return $items;
    }
}
