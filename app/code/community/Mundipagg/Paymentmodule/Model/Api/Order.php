<?php
/**
 * This class is a Wrapper to the MundiPagg SDK
 *
 * @package Mundipagg/Paymentmodule
 */

require_once Mage::getBaseDir('lib') . '/autoload.php';

use MundiAPILib\MundiAPIClient;

class Mundipagg_Paymentmodule_Model_Api_Order
{
    public function createBoletoPayment(Varien_Object $paymentInformation)
    {
        $boleto = Mage::getModel('paymentmodule/api_boleto');

        $orderController = $this->getOrderController();
        return $orderController->createOrder(
            $boleto->getCreateOrderRequest($paymentInformation)
        );
    }

    public function createCreditCardPayment(Varien_Object $paymentInformation)
    {
        $boleto = Mage::getModel('paymentmodule/api_creditcard');

        $orderController = $this->getOrderController();
        return $orderController->createOrder(
            $boleto->getCreateOrderRequest($paymentInformation)
        );
    }

    private function getOrderController()
    {
        $client = $this->getMundiPaggApiClient();

        return $client->getOrders();
    }

    private function getMundiPaggApiClient()
    {
        $generalConfig = Mage::getModel('paymentmodule/config_general');
        $secretKey = $generalConfig->getSecretKey();
        $password = $generalConfig->getPassword();

        return new MundiAPIClient($secretKey, $password);
    }
}
