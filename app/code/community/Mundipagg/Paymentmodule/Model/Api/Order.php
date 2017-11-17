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
        $orderRequest = $boleto->getCreateOrderRequest($paymentInformation);

        $orderController = $this->getOrderController();
        try {
            return $orderController->createOrder($orderRequest);
        } catch (\MundiAPILib\Exceptions\ErrorException $e) {
            Mage::log(
                $e->getMessage()."\n".$e->getContext()->getResponse()->getRawBody(),
                Zend_log::EMERG
            );
        }
    }

    public function createCreditCardPayment(Varien_Object $paymentInformation)
    {
        $creditCard = Mage::getModel('paymentmodule/api_creditcard');
        $orderRequest = $creditCard->getCreateOrderRequest($paymentInformation);

        $orderController = $this->getOrderController();
        return $orderController->createOrder($orderRequest);
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
