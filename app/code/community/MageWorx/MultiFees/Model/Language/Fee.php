<?php
/**
 * MageWorx
 * Multi Fees Extension
 *
 * @category   MageWorx
 * @package    MageWorx_MultiFees
 * @copyright  Copyright (c) 2015 MageWorx (http://www.mageworx.com/)
 */

class MageWorx_MultiFees_Model_Language_Fee extends Mage_Core_Model_Abstract
{
    public function _construct() {
        $this->_init('mageworx_multifees/language_fee');
    }

    /**
     * @param $feeId
     * @param $storeId
     * @return $this
     */
    public function loadByFeeAndStore($feeId, $storeId) {
	$this->getResource()->loadByFeeAndStore($this, $feeId, $storeId);
        return $this;
    }
    
}