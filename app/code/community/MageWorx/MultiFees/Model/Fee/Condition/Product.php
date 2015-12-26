<?php
/**
 * MageWorx
 * Multi Fees Extension
 *
 * @category   MageWorx
 * @package    MageWorx_MultiFees
 * @copyright  Copyright (c) 2015 MageWorx (http://www.mageworx.com/)
 */

class MageWorx_MultiFees_Model_Fee_Condition_Product extends Mage_SalesRule_Model_Rule_Condition_Product //Mage_Rule_Model_Condition_Abstract
{
    /**
     * @return $this|Mage_CatalogRule_Model_Rule_Condition_Product
     */
    public function loadAttributeOptions() {
        $attributes = array('product_type' => Mage::helper('catalog')->__('Product Type'));
        $this->setAttributeOption($attributes);
        return $this;
    }

    /**
     * @return array
     */
    public function getValueSelectOptions() {
        $productTypes = Mage::getSingleton('catalog/product_type')->getOptionArray();
        foreach ($productTypes as $code=>$label) {
            $values[] = array('value'=>$code, 'label'=>$label);
        }
        return $values;
    }

    /**
     * @return string
     */
    public function getValueElementType() {
        return 'select';
    }

    /**
     * @return string
     */
    public function getInputType() {
        return 'select';        
    }

    /**
     * @param Varien_Object $object
     * @return bool
     */
    public function validate(Varien_Object $object) {
        // check product type
        if ($this->getAttribute()=='product_type') {
            if ($object->getProduct() instanceof Mage_Catalog_Model_Product) {
                $product = $object->getProduct();
            } else {
                $product = Mage::getModel('catalog/product')->load($object->getProductId());
            }
            if ($product->getTypeId()==$this->getValue()) return true; else return false;            
        }
        
        return parent::validate($object);
    }            
    
    
}
