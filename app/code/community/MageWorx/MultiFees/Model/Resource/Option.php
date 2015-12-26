<?php
/**
 * MageWorx
 * Multi Fees Extension
 *
 * @category   MageWorx
 * @package    MageWorx_MultiFees
 * @copyright  Copyright (c) 2015 MageWorx (http://www.mageworx.com/)
 */

class MageWorx_MultiFees_Model_Resource_Option extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct() {
        $this->_init('mageworx_multifees/option', 'fee_option_id');
    }

    public function getOptions($feeId) {
        $read = $this->_getReadAdapter();
        $result = $read->fetchAssoc(
            $read->select()
                ->from($this->getMainTable())
                ->where('fee_id = ?', $feeId)
        );
        return $result;
    }

    protected function _beforeDelete(Mage_Core_Model_Abstract $object) {
        Mage::helper('mageworx_multifees')->removeOptionFile($object->getId());
        return parent::_beforeDelete($object);
    }
    
}