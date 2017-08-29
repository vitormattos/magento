<?php

class Mundipagg_Block_Adminhtml_Form_Field_Installments 
    extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract {
    
    protected function _prepareToRender()
    {
        $this->addColumn('installment_boundary', array(
            'label' => Mage::helper('mundipagg')->__('Amount (incl.)'),
            'style' => 'width:100px',
        ));
        $this->addColumn('installment_frequency', array(
            'label' => Mage::helper('mundipagg')->__('Maximum Number of Installments'),
            'style' => 'width:100px',
        ));
        $this->addColumn('installment_interest', array(
            'label' => Mage::helper('mundipagg')->__('Interest Rate (%)'),
            'style' => 'width:100px',
        ));
        $this->_addAfter = false;
        $this->_addButtonLabel = Mage::helper('mundipagg')->__('Add Installment Boundary');
        
        $this->_template;
    }
}