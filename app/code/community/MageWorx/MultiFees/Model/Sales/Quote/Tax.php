<?php
/**
 * MageWorx
 * Multi Fees Extension
 *
 * @category   MageWorx
 * @package    MageWorx_MultiFees
 * @copyright  Copyright (c) 2015 MageWorx (http://www.mageworx.com/)
 */

class MageWorx_MultiFees_Model_Sales_Quote_Tax extends Mage_Sales_Model_Quote_Address_Total_Abstract
{

    public function __construct() {
        $this->setCode('multifees');
    }

    /**
     * @param Mage_Sales_Model_Quote_Address $address
     * @return $this|Mage_Sales_Model_Quote_Address_Total_Abstract
     */
    public function collect(Mage_Sales_Model_Quote_Address $address) {
        return $this;
    }

    /**
     * @param Mage_Sales_Model_Quote_Address $address
     * @return $this|array
     */
    public function fetch(Mage_Sales_Model_Quote_Address $address) {
        if ($address->getMultifeesAmount()==0) return $this;
        
        $helper = Mage::helper('mageworx_multifees');
        // if $taxMode==3 ---> show Price Incl. Tax
        if ($helper->getTaxInCart()==3 && $address->getDetailsMultifees()) {
            $address->addTotal(array(
                'code' => $this->getCode(),
                'title' => $helper->__('Additional Fees (Incl. Tax)'),
                'value' => $address->getMultifeesAmount(),
                'full_info' => $address->getDetailsMultifees(),
            ));
        }
        return $this;
    }

}