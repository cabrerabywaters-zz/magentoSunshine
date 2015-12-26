<?php
/**
 * MageWorx
 * Multi Fees Extension
 *
 * @category   MageWorx
 * @package    MageWorx_MultiFees
 * @copyright  Copyright (c) 2015 MageWorx (http://www.mageworx.com/)
 */

class MageWorx_MultiFees_Model_Fee_Condition_Address_Shipping extends Mage_SalesRule_Model_Rule_Condition_Address
{
    /**
     * @return $this
     */
    public function loadAttributeOptions()
    {
        $attributes = array(
            'postcode' => Mage::helper('salesrule')->__('Shipping Postcode'),
            'region' => Mage::helper('salesrule')->__('Shipping Region'),
            'region_id' => Mage::helper('salesrule')->__('Shipping State/Province'),
            'country_id' => Mage::helper('salesrule')->__('Shipping Country'),
        );

        $this->setAttributeOption($attributes);

        return $this;
    }
}
