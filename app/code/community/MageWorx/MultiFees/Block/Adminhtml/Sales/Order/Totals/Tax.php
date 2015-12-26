<?php
/**
 * MageWorx
 * Multi Fees Extension
 *
 * @category   MageWorx
 * @package    MageWorx_MultiFees
 * @copyright  Copyright (c) 2015 MageWorx (http://www.mageworx.com/)
 */

class MageWorx_MultiFees_Block_Adminhtml_Sales_Order_Totals_Tax extends Mage_Adminhtml_Block_Sales_Order_Totals_Tax
{
    /**
     * @return array
     */
    public function getFullTaxInfo() {
        /** @var $source Mage_Sales_Model_Order */
        $source = $this->getOrder();

        $taxClassAmount = array();
        if ($source instanceof Mage_Sales_Model_Order) {
            $rates = Mage::getModel('sales/order_tax')->getCollection()->loadByOrder($source)->toArray();
            $taxClassAmount =  Mage::getSingleton('tax/calculation')->reproduceProcess($rates['items']);
        }

        return $taxClassAmount;
    }
 
}