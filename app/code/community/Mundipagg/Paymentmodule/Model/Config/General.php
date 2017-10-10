<?php

class Mundipagg_Paymentmodule_Model_Config_General
{
    public function isEnabled()
    {
        return Mage::getStoreConfig('mundipagg_config/general_group/module_status') == 1;
    }

    public function isLogEnabled()
    {
        return Mage::getStoreConfig('mundipagg_config/general_group/logs') == 1;
    }

    public function getProdSecretKey()
    {
        return Mage::getStoreConfig('mundipagg_config/general_group/sk_prod');
    }

    public function getTestSecretKey()
    {
        return Mage::getStoreConfig('mundipagg_config/general_group/sk_test');
    }

    public function getProdPublicKey()
    {
        return Mage::getStoreConfig('mundipagg_config/general_group/pk_prod');
    }

    public function getTestPublicKey()
    {
        return Mage::getStoreConfig('mundipagg_config/general_group/pk_test');
    }

    public function isTestModeEnabled()
    {
        return Mage::getStoreConfig('mundipagg_config/general_group/test_mode') == 1;
    }
}
