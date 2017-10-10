<?php

class Mundipagg_Paymentmodule_Model_Config_Boleto
{
    public function isEnabled()
    {
        return Mage::getStoreConfig('mundipagg_config/boleto_group/boleto_status') == 1;
    }

    public function getPaymentTitle()
    {
        return Mage::getStoreConfig('mundipagg_config/boleto_group/boleto_payment_title');
    }

    public function getName()
    {
        return Mage::getStoreConfig('mundipagg_config/boleto_group/boleto_name');
    }

    public function getBank()
    {
        return Mage::getStoreConfig('mundipagg_config/boleto_group/boleto_bank');
    }

    public function getDueAt()
    {
        return Mage::getStoreConfig('mundipagg_config/boleto_group/boleto_due_at');
    }

    public function getInstructions()
    {
        return Mage::getStoreConfig('mundipagg_config/boleto_group/boleto_instructions');
    }
}
