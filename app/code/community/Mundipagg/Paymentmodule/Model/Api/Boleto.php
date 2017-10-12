<?php

require_once Mage::getBaseDir('lib') . '/autoload.php';

use MundiAPILib\Models\CreateOrderRequest;
use MundiAPILib\Models\CreateCustomerRequest;
use MundiAPILib\Models\CreateAddressRequest;
use MundiAPILib\Models\CreatePhonesRequest;
use MundiAPILib\Models\CreatePhoneRequest;
use MundiAPILib\Models\CreatePaymentRequest;
use MundiAPILib\Models\CreateBoletoPaymentRequest;

class Mundipagg_Paymentmodule_Model_Api_Boleto
{
    public function getCreateOrderRequest($paymentInformation)
    {
        $orderRequest = new CreateOrderRequest();

        $orderRequest->items = $paymentInformation->getItemsInfo();
        $orderRequest->customer = $this->getCustomerRequest($paymentInformation->getCustomerInfo());
        $orderRequest->payments = $this->getPayments($paymentInformation->getPaymentInfo());
        $orderRequest->code = 'xxx';
        $orderRequest->metadata = $paymentInformation->getMetainfo();

        return $orderRequest;
    }

    private function getCustomerRequest($customerInfo)
    {
        return new CreateCustomerRequest(
            $customerInfo->getName(),
            $customerInfo->getEmail(),
            $customerInfo->getDocument(),
            $customerInfo->getType(),
            $this->getCreateAddressRequest($customerInfo->getAddress()),
            $customerInfo->getMetadata(),
            $this->getCreatePhonesRequest($customerInfo->getPhones()),
            $customerInfo->getCode()
        );
    }

    private function getCreateAddressRequest($addressInfo)
    {
        return new CreateAddressRequest(
            $addressInfo->getStreet(),
            $addressInfo->getNumber(),
            $addressInfo->getZipCode(),
            $addressInfo->getNeighborhood(),
            $addressInfo->getCity(),
            $addressInfo->getState(),
            $addressInfo->getCountry(),
            $addressInfo->getComplement(),
            $addressInfo->getMetadata()
        );
    }

    private function getCreatePhonesRequest($phonesInfo)
    {
        return new CreatePhonesRequest(
            $this->getHomePhone($phonesInfo),
            $this->getMobilePhone($phonesInfo)
        );
    }

    private function getHomePhone($phonesInfo)
    {
        return new CreatePhoneRequest(
            $phonesInfo->getCountryCode(),
            $phonesInfo->getNumber(),
            $phonesInfo->getAreacode()
        );
    }

    private function getMobilePhone($phonesInfo)
    {
        return new CreatePhoneRequest(
            $phonesInfo->getCountryCode(),
            $phonesInfo->getNumber(),
            $phonesInfo->getAreacode()
        );
    }

    private function getPayments($paymentInfo)
    {
        $paymentRequest = new CreatePaymentRequest();

        $boletoPaymentRequest = new CreateBoletoPaymentRequest();
        $boletoPaymentRequest->bank = $paymentInfo->getBank();
        $boletoPaymentRequest->instructions = $paymentInfo->getInstructions();
        $boletoPaymentRequest->dueAt = $paymentInfo->getDueAt();

        $paymentRequest->paymentMethod = 'boleto';
        $paymentRequest->boleto = $boletoPaymentRequest;
        // @todo this should not be hard coded
        $paymentRequest->currency = 'BRL';

        return array($boletoPayment);
    }
}