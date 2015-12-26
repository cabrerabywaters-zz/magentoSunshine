<?php
/**
 * MageWorx
 * Multi Fees Extension
 *
 * @category   MageWorx
 * @package    MageWorx_MultiFees
 * @copyright  Copyright (c) 2015 MageWorx (http://www.mageworx.com/)
 */

class MageWorx_MultiFees_Model_System_Config_Source_Position
{
    /**
     * @return array
     */
    public function toOptionArray() {
        $helper = Mage::helper('mageworx_multifees');
        return array(
            array('value' => 0, 'label' => $helper->__('Custom Position')),
            array('value' => 1, 'label' => $helper->__('Above Crosssell')),
            array('value' => 2, 'label' => $helper->__('Below Crosssell')),
            array('value' => 3, 'label' => $helper->__('Above Coupon')),
            array('value' => 4, 'label' => $helper->__('Below Coupon')),
            array('value' => 5, 'label' => $helper->__('Above Estimate Shipping')),
            array('value' => 6, 'label' => $helper->__('Below Estimate Shipping'))            
        );
        
    }
}