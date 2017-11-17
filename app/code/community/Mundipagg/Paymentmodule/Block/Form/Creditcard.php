<?php


class Mundipagg_Paymentmodule_Block_Form_Creditcard extends Mage_Payment_Block_Form
{
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('paymentmodule/form/creditcard.phtml');
    }
    
    /**
     * Retrieve payment configuration object
     *
     * @return Mage_Payment_Model_Config
     */
    protected function _getConfig()
    {
        return Mage::getSingleton('payment/config');
    }
    
    /**
     * Retrieve credit card expire months
     *
     * @return array
     */
    public function getCcMonths()
    {
        $months = $this->getData('cc_months');
        if (is_null($months)) {
            $months = Mage::getSingleton('payment/config')->getMonths();
            $months = array(0=>$this->__('Month'))+$months;
            $this->setData('cc_months', $months);
        }
        return $months;
    }
    
    /**
     * Retrieve credit card expire years
     *
     * @return array
     */
    public function getCcYears()
    {
        $years = $this->getData('cc_years');
        if (is_null($years)) {
            $years = Mage::getSingleton('payment/config')->getYears();
            $years = array(0=>$this->__('Year'))+$years;
            $this->setData('cc_years', $years);
        }
        return $years;
    }
    
    public function getInstallmentsStatus()
    {
        return Mage::getStoreConfig('mundipagg_config/installments_group/default_status');
    }
}
