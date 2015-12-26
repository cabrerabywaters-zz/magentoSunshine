<?php
/**
 * MageWorx
 * Multi Fees Extension
 *
 * @category   MageWorx
 * @package    MageWorx_MultiFees
 * @copyright  Copyright (c) 2015 MageWorx (http://www.mageworx.com/)
 */

class MageWorx_MultiFees_Block_Adminhtml_Sales_Order_Create_Total extends Mage_Adminhtml_Block_Sales_Order_Create_Totals_Default
{
    protected $_template = 'mageworx/multifees/create_totals.phtml';

    /**
     * @return bool
     */
    public function isInclTax() {
        $code = $this->getTotal()->getCode();        
        if ($code=='mageworx_multifees') {
            if (Mage::helper('mageworx_multifees')->getTaxInCart()==2) return true; else return false;
        } elseif ($code=='mageworx_multifees_tax') {
            return true;
        }
        return true;
    }
 
}