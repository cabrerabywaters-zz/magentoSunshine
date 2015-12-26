<?php

class Magestore_Inventorycustomer_Block_Adminhtml_Allcustomers_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm() {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        if (Mage::getSingleton('adminhtml/session')->getData('inventorycustomer_customer_data')) {
            $data = Mage::getSingleton('adminhtml/session')->getData('inventorycustomer_customer_data');
            Mage::getSingleton('adminhtml/session')->setData('inventorycustomer_customer_data', null);
        } elseif (Mage::registry('inventorycustomer_customer_data')) {
            $data = Mage::registry('inventorycustomer_customer_data')->getData();
        }

        $fieldset = $form->addFieldset('customer_detail_form', array('legend' => Mage::helper('inventorycustomer')->__('Additional Information')));

        $fieldset->addField('customer_satisfaction_type', 'select', array(
            'label' => Mage::helper('inventorycustomer')->__('Customer Type'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'customer_satisfaction_type',
            'values' => Mage::getSingleton('inventorycustomer/attribute_source_customer')->getOptionArray(),
            'tabindex' => 1
        ));

        $fieldset->addField('customer_notes', 'textarea', array(
            'label' => 'Notes',
            'name' => 'customer_notes',
        ));

        $form->setValues($data);
        return parent::_prepareForm();
    }

}
