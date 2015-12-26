<?php
/**
 * MageWorx
 * Multi Fees Extension
 *
 * @category   MageWorx
 * @package    MageWorx_MultiFees
 * @copyright  Copyright (c) 2015 MageWorx (http://www.mageworx.com/)
 */

class MageWorx_MultiFees_Block_Fee extends Mage_Core_Block_Template
{
    /**
     * @return mixed
     */
    public function getCmsBlockHtml() {
        return $this->getLayout()->createBlock('cms/block')
                    ->setBlockId(Mage::getStoreConfig('mageworx_multifees/main/static_block_for_cart_page'))
                    ->toHtml();
    }

    /**
     * @return Mage_Core_Model_Abstract
     */
    protected function _getSession() {
        return Mage::getSingleton('checkout/session');
    }

    /**
     * @param $feeId
     * @param int $addressId
     * @return string
     */
    public function getFeeMessage($feeId, $addressId = 0) {
        $detailsFees = Mage::helper('mageworx_multifees')->getQuoteDetailsMultifees($addressId);
        if (isset($detailsFees[$feeId]['message'])) {
            return $this->htmlEscape($detailsFees[$feeId]['message']);
        } else {
            return '';
        }
    }

    /**
     * @param $feeId
     * @param int $addressId
     * @return string
     */
    public function getFeeDate($feeId, $addressId = 0) {
        $detailsFees = Mage::helper('mageworx_multifees')->getQuoteDetailsMultifees($addressId);
        if (isset($detailsFees[$feeId]['date'])) {
            return $detailsFees[$feeId]['date'];
        } else {
            return '';
        }
    }

    /**
     * @return string
     */
    public function getDateFormat() {
        return Mage::app()->getLocale()->getDateStrFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT);
    }
 
}