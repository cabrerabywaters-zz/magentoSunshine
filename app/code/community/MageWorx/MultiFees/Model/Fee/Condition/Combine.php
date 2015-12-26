<?php
/**
 * MageWorx
 * Multi Fees Extension
 *
 * @category   MageWorx
 * @package    MageWorx_MultiFees
 * @copyright  Copyright (c) 2015 MageWorx (http://www.mageworx.com/)
 */

class MageWorx_MultiFees_Model_Fee_Condition_Combine extends Mage_Rule_Model_Condition_Combine
{
    public function __construct() {
        parent::__construct();
        $this->setType('mageworx_multifees/fee_condition_combine');
    }

    /**
     * @return array
     */
    public function getNewChildSelectOptions() {
        $addressAttributes = array();
        $addressAttributesBilling = array();
        $addressAttributesShipping = array();
        $addressAttributesTmp = Mage::getModel('salesrule/rule_condition_address')->loadAttributeOptions()->getAttributeOption();

        // only base_subtotal, total_qty, weight
        if (isset($addressAttributesTmp['base_subtotal'])) $addressAttributes['base_subtotal'] = $addressAttributesTmp['base_subtotal'];
        if (isset($addressAttributesTmp['total_qty'])) $addressAttributes['total_qty'] = $addressAttributesTmp['total_qty'];
        if (isset($addressAttributesTmp['weight'])) $addressAttributes['weight'] = $addressAttributesTmp['weight'];

        $addressAttributesTmp = Mage::getModel('mageworx_multifees/fee_condition_address_billing')->loadAttributeOptions()->getAttributeOption();
        if (isset($addressAttributesTmp['postcode'])) $addressAttributesBilling['postcode'] = $addressAttributesTmp['postcode'];
        if (isset($addressAttributesTmp['region'])) $addressAttributesBilling['region'] = $addressAttributesTmp['region'];
        if (isset($addressAttributesTmp['country_id'])) $addressAttributesBilling['country_id'] = $addressAttributesTmp['country_id'];
        if (isset($addressAttributesTmp['region_id'])) $addressAttributesBilling['region_id'] = $addressAttributesTmp['region_id'];

        $addressAttributesTmp = Mage::getModel('mageworx_multifees/fee_condition_address_shipping')->loadAttributeOptions()->getAttributeOption();
        if (isset($addressAttributesTmp['postcode'])) $addressAttributesShipping['postcode'] = $addressAttributesTmp['postcode'];
        if (isset($addressAttributesTmp['region'])) $addressAttributesShipping['region'] = $addressAttributesTmp['region'];
        if (isset($addressAttributesTmp['country_id'])) $addressAttributesShipping['country_id'] = $addressAttributesTmp['country_id'];
        if (isset($addressAttributesTmp['region_id'])) $addressAttributesShipping['region_id'] = $addressAttributesTmp['region_id'];



        $attributes = array();
        foreach ($addressAttributes as $code=>$label) {
            $attributes[] = array('value'=>'salesrule/rule_condition_address|'.$code, 'label'=>$label);
        }
        foreach ($addressAttributesBilling as $code=>$label) {
            $attributes[] = array('value'=>'mageworx_multifees/fee_condition_address_billing|'.$code, 'label'=>$label);
        }
        foreach ($addressAttributesShipping as $code=>$label) {
            $attributes[] = array('value'=>'mageworx_multifees/fee_condition_address_shipping|'.$code, 'label'=>$label);
        }


        $conditions = parent::getNewChildSelectOptions();
        $conditions = array_merge_recursive($conditions, array(
            array('value'=>'mageworx_multifees/fee_condition_product_found', 'label'=>Mage::helper('salesrule')->__('Product attribute combination')),
            array('value'=>'mageworx_multifees/fee_condition_combine', 'label'=>Mage::helper('salesrule')->__('Conditions combination')),
            array('label'=>Mage::helper('salesrule')->__('Cart Attribute'), 'value'=>$attributes),
        ));

        $additional = new Varien_Object();
        Mage::dispatchEvent('salesrule_rule_condition_combine', array('additional' => $additional));
        if ($additionalConditions = $additional->getConditions()) {
            $conditions = array_merge_recursive($conditions, $additionalConditions);
        }

        return $conditions;
    }

    /**
     * @param Varien_Object $object
     * @return bool
     */
    public function validate(Varien_Object $object) {
        if (!$this->getConditions()) {
            Mage::registry('multifees_fee')->addAllQuoteItemQty($object);
            return true;
        }
        
        $all    = $this->getAggregator() === 'all';
        $true   = (bool)$this->getValue();
        $productFoundCondition = false;
        
        foreach ($this->getConditions() as $cond) {
            if ($cond instanceof MageWorx_MultiFees_Model_Fee_Condition_Product_Found) $productFoundCondition = true;
            $validated = $cond->validate($object);
            if ($all && $validated !== $true) {
                return false;
            } elseif (!$all && $validated === $true) {
                if (!($cond instanceof MageWorx_MultiFees_Model_Fee_Condition_Product_Found)) Mage::registry('multifees_fee')->addAllQuoteItemQty($object);
                return true;
            }
        }
        
        if ($all) {
            if (!$productFoundCondition) Mage::registry('multifees_fee')->addAllQuoteItemQty($object);
            return true;
        } else {
            return false;
        }
    }
    
}
