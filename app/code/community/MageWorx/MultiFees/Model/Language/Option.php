<?php
/**
 * MageWorx
 * Multi Fees Extension
 *
 * @category   MageWorx
 * @package    MageWorx_MultiFees
 * @copyright  Copyright (c) 2015 MageWorx (http://www.mageworx.com/)
 */

class MageWorx_MultiFees_Model_Language_Option extends Mage_Core_Model_Abstract
{
    public function _construct() {
        $this->_init('mageworx_multifees/language_option');
    }

    /**
     * @param $optionId
     * @param $storeId
     * @return $this
     */
    public function loadByOptionAndStore($optionId, $storeId) {
	$this->getResource()->loadByOptionAndStore($this, $optionId, $storeId);
        return $this;
    }
    
}