<?php
/**
 * MageWorx
 * Multi Fees Extension
 *
 * @category   MageWorx
 * @package    MageWorx_MultiFees
 * @copyright  Copyright (c) 2015 MageWorx (http://www.mageworx.com/)
 */

class MageWorx_MultiFees_Model_Fee_Condition_Product_Combine extends Mage_SalesRule_Model_Rule_Condition_Product_Combine
{
    public function __construct() {
        parent::__construct();
        $this->setType('mageworx_multifees/fee_condition_product_combine');
    }

    /**
     * @return array
     */
    public function getNewChildSelectOptions() {
        $productAttributes = Mage::getModel('salesrule/rule_condition_product')->loadAttributeOptions()->getAttributeOption();
        $pAttributes = array();
        $iAttributes = array();
        foreach ($productAttributes as $code=>$label) {
            if (strpos($code, 'quote_item_')===0) {
                $iAttributes[] = array('value'=>'salesrule/rule_condition_product|'.$code, 'label'=>$label);
            } else {
                $pAttributes[] = array('value'=>'salesrule/rule_condition_product|'.$code, 'label'=>$label);
            }
        }

        $conditions = array(
            array('value'=>'', 'label'=>Mage::helper('rule')->__('Please choose a condition to add...')),
            array('value'=>'mageworx_multifees/fee_condition_product_combine', 'label'=>Mage::helper('catalog')->__('Conditions Combination')),
            array('label'=>Mage::helper('catalog')->__('Cart Item Attribute'), 'value'=>$iAttributes),
            array('label'=>Mage::helper('catalog')->__('Product'), 'value'=>array(array('value'=>'mageworx_multifees/fee_condition_product|product_type', 'label'=>Mage::helper('catalog')->__('Type')))),
            array('label'=>Mage::helper('catalog')->__('Product Attribute'), 'value'=>$pAttributes),
        );
                
        return $conditions;
    }
    
}
