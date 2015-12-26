<?php
/**
 * MageWorx
 * Multi Fees Extension
 *
 * @category   MageWorx
 * @package    MageWorx_MultiFees
 * @copyright  Copyright (c) 2015 MageWorx (http://www.mageworx.com/)
 */

class MageWorx_MultiFees_Model_Resource_Language_Fee extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct() {
        $this->_init('mageworx_multifees/language_fee', 'fee_lang_id');
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

    public function getTitle($feeId, $storeId = 0) {
        $read = $this->_getReadAdapter();
        $select = $read->select()
            ->from($this->getMainTable(), 'title')
            ->where('fee_id = ?', $feeId)
            ->where('store_id = ?', $storeId);
        $title = $read->fetchOne($select);
        
        if (!$title && $storeId!=0) {
            $select = $read->select()
                ->from($this->getMainTable(), 'title')
                ->where('fee_id = ?', $feeId)
                ->where('store_id = 0');
            $title = $read->fetchOne($select);
        }
        return $title;
    }
}