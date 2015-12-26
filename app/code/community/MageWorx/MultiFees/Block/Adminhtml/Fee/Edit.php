<?php
/**
 * MageWorx
 * Multi Fees Extension
 *
 * @category   MageWorx
 * @package    MageWorx_MultiFees
 * @copyright  Copyright (c) 2015 MageWorx (http://www.mageworx.com/)
 */

class MageWorx_MultiFees_Block_Adminhtml_Fee_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct() {
        $this->_objectId = 'fee_id';
        $this->_blockGroup = 'mageworx_multifees';
        $this->_controller = 'adminhtml_fee';
        parent::__construct();        
        $this->removeButton('reset');
        
        $this->_updateButton('delete', 'label', $this->__('Delete Fee'));
        $this->_updateButton('save', 'label', $this->__('Save Fee'));
        
        $this->_addButton('save_and_continue', array(
            'label'     => Mage::helper('catalog')->__('Save and Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class' => 'save'
        ), 10);
        
        
        // set last tab
        $tab = Mage::app()->getRequest()->getParam('tab');
        
        $this->_formScripts[] = " function saveAndContinueEdit(){ editForm.submit($('edit_form').action + 'back/edit/tab/'+fee_edit_tabsJsTabs.activeTab.id+'/') }
            function hideAllOptions() {
                $$('option[value=\"mageworx_multifees/fee_condition_address_billing|country_id\"]').each(function(el){
                    el.hide();
                });
                $$('option[value=\"mageworx_multifees/fee_condition_address_billing|region_id\"]').each(function(el){
                    el.hide();
                });
                $$('option[value=\"mageworx_multifees/fee_condition_address_billing|postcode\"]').each(function(el){
                    el.hide();
                });
                $$('option[value=\"mageworx_multifees/fee_condition_address_billing|region\"]').each(function(el){
                   el.hide();
                });
                $$('option[value=\"mageworx_multifees/fee_condition_address_shipping|country_id\"]').each(function(el){
                    el.hide();
                });
                $$('option[value=\"mageworx_multifees/fee_condition_address_shipping|region_id\"]').each(function(el){
                    el.hide();
                });
                $$('option[value=\"mageworx_multifees/fee_condition_address_shipping|postcode\"]').each(function(el){
                    el.hide();
                });
                $$('option[value=\"mageworx_multifees/fee_condition_address_shipping|region\"]').each(function(el){
                    el.hide();
                });
            }
            function hideShippingOptions() {
                $$('option[value=\"mageworx_multifees/fee_condition_address_billing|country_id\"]').each(function(el){
                    el.show();
                });
                $$('option[value=\"mageworx_multifees/fee_condition_address_billing|region_id\"]').each(function(el){
                    el.show();
                });
                $$('option[value=\"mageworx_multifees/fee_condition_address_billing|postcode\"]').each(function(el){
                    el.show();
                });
                $$('option[value=\"mageworx_multifees/fee_condition_address_billing|region\"]').each(function(el){
                    el.show();
                });
                $$('option[value=\"mageworx_multifees/fee_condition_address_shipping|country_id\"]').each(function(el){
                    el.hide();
                });
                $$('option[value=\"mageworx_multifees/fee_condition_address_shipping|region_id\"]').each(function(el){
                    el.hide();
                });
                $$('option[value=\"mageworx_multifees/fee_condition_address_shipping|postcode\"]').each(function(el){
                    el.hide();
                });
                $$('option[value=\"mageworx_multifees/fee_condition_address_shipping|region\"]').each(function(el){
                    el.hide();
                });
            }
            function hideBillingOptions() {
                $$('option[value=\"mageworx_multifees/fee_condition_address_billing|country_id\"]').each(function(el){
                    el.hide();
                });
                $$('option[value=\"mageworx_multifees/fee_condition_address_billing|region_id\"]').each(function(el){
                    el.hide();
                });
                $$('option[value=\"mageworx_multifees/fee_condition_address_billing|postcode\"]').each(function(el){
                    el.hide();
                });
                $$('option[value=\"mageworx_multifees/fee_condition_address_billing|region\"]').each(function(el){
                     el.hide();
                });
                $$('option[value=\"mageworx_multifees/fee_condition_address_shipping|country_id\"]').each(function(el){
                    el.show();
                });
                $$('option[value=\"mageworx_multifees/fee_condition_address_shipping|region_id\"]').each(function(el){
                    el.show();
                });
                $$('option[value=\"mageworx_multifees/fee_condition_address_shipping|postcode\"]').each(function(el){
                    el.show();
                });
                $$('option[value=\"mageworx_multifees/fee_condition_address_shipping|region\"]').each(function(el){
                    el.show();
                });
            }
            function changeConditionsBasedOnType(el){
                if (el.value==1) {
                    $('rule_payments_fieldset').previous().hide();
                    $('rule_payments_fieldset').hide();
                    $('rule_shippings_fieldset').previous().hide();
                    $('rule_shippings_fieldset').hide();
                    hideAllOptions();
                } else if (el.value==2) {
                    $('rule_payments_fieldset').previous().show();
                    $('rule_payments_fieldset').show();
                    $('rule_shippings_fieldset').previous().hide();
                    $('rule_shippings_fieldset').hide();
                    hideShippingOptions();
                } else if (el.value==3) {
                    $('rule_payments_fieldset').previous().hide();
                    $('rule_payments_fieldset').hide();                   
                    $('rule_shippings_fieldset').previous().show();
                    $('rule_shippings_fieldset').show();
                    hideBillingOptions();
                }
            }
            changeConditionsBasedOnType($('fee_type'));

            $('fee_type').observe('change',function() {
                $$('.rule-param-remove').each(function(el){
                    el.click();
                });
            });

            $('applied_totals').size = 3;".
            ($tab?"fee_edit_tabsJsTabs.setSkipDisplayFirstTab(); fee_edit_tabsJsTabs.showTabContent($('".$tab."'));":"");
    }

    /**
     * @return string
     */
    public function getHeaderText() {
        $model = Mage::registry('multifees_fee');
        if ($model && $model->getId()) {            
            return $this->__("Edit Fee '%s'", $this->htmlEscape($model->getTitle()));
        } else {
            return $this->__('New Fee');
        }        
    }
    
}
