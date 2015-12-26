<?php
/**
 * MageWorx
 * Multi Fees Extension
 *
 * @category   MageWorx
 * @package    MageWorx_MultiFees
 * @copyright  Copyright (c) 2015 MageWorx (http://www.mageworx.com/)
 */

class MageWorx_MultiFees_Model_Resource_Store extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct() {
        $this->_init('mageworx_multifees/store', 'fee_store_id');
    }
    
    public function loadByFeeAndStore($object, $feeId, $storeId) {
	$object->unsetData();
        $read = $this->_getReadAdapter();
        if ($read) {  
            $select = $read->select()
                ->from($this->getMainTable())
                ->where('fee_id = ?', $feeId)
                ->where('store_id = ?', $storeId)
                ->limit(1); 
            $data = $read->fetchRow($select);
            if ($data) $object->addData($data);
        }
    }
    
    public function getStories($feeId) {
        $read = $this->_getReadAdapter();
        $result = $read->fetchAssoc(
            $read->select()
                ->from($this->getMainTable())
                ->where('fee_id = ?', $feeId)
        );
        return $result;
    }   
    
}