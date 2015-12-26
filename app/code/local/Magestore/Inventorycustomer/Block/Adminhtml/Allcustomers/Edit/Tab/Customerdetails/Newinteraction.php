<?php

/**
 * Magestore
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the Magestore.com license that is
 * available through the world-wide-web at this URL:
 * http://www.magestore.com/license-agreement.html
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category    Magestore
 * @package     Magestore_Inventorycustomer
 * @copyright   Copyright (c) 2012 Magestore (http://www.magestore.com/)
 * @license     http://www.magestore.com/license-agreement.html
 */

/**
 * Inventorycustomer Adminhtml Block
 * 
 * @category    Magestore
 * @package     Magestore_Inventorycustomer
 * @author      Magestore Developer
 */
class Magestore_Inventorycustomer_Block_Adminhtml_Allcustomers_Edit_Tab_Customerdetails_Newinteraction extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm() {

        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/addinteraction'),
            'method' => 'post',
            'enctype' => 'multipart/form-data',
                )
        );

        $fieldset = $form->addFieldset('newinteraction_form', array('legend' => Mage::helper('inventorycustomer')->__('Enter value here')));

        $fieldset->addField('newinteraction_action', 'select', array(
            'label' => Mage::helper('inventorycustomer')->__('Action'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'newinteraction_action',
            'values' => Mage::getSingleton('inventorycustomer/system_config_source_action')->getOptionArray(),
            'tabindex' => 1
        ));
        $fieldset->addField('newinteraction_result', 'select', array(
            'label' => 'Result',
            'class' => 'required-entry',
            'required' => true,
            'name' => 'newinteraction_result',
            'values' => Mage::getSingleton('inventorycustomer/system_config_source_result')->getOptionArray(),
            'tabindex' => 1
        ));
        $fieldset->addField('newinteraction_next_action', 'select', array(
            'label' => 'Next Action',
            'name' => 'newinteraction_next_action',
            'values' => Mage::getSingleton('inventorycustomer/system_config_source_action')->getOptionArray(),
            'tabindex' => 1
        ));
        $fieldset->addField('newinteraction_remindat', 'date', array(
            'label' => 'Remind At',
            'name' => 'newinteraction_remindat',
            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format' => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT)
        ));

        $fieldset->addField('submit_btn', 'button', array(
            'name' => 'submit_btn',
            'value' => $this->helper('inventorycustomer')->__('Submit'),
            'class' => 'form-button',
            'onclick' => 'addNewInteraction();'
        ));

        $form->setUseContainer(true);
        $this->setForm($form);

        parent::_prepareForm();
    }

}
