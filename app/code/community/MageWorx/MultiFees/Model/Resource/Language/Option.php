<?php
/**
 * MageWorx
 * Multi Fees Extension
 *
 * @category   MageWorx
 * @package    MageWorx_MultiFees
 * @copyright  Copyright (c) 2015 MageWorx (http://www.mageworx.com/)
 */

class MageWorx_MultiFees_Model_Resource_Language_Option extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct() {
        $this->_init('mageworx_multifees/language_option', 'fee_option_lang_id');
    }

    
    public function loadByOptionAndStore($object, $optionId, $storeId) {
	$object->unsetData();
        $read = $this->_getReadAdapter();
        if ($read) {  
            $select = $read->select()
                ->from($this->getMainTable())
                ->where('fee_option_id = ?', $optionId)
                ->where('store_id = ?', $storeId)
                ->limit(1); 
            $data = $read->fetchRow($select);
            if ($data) $object->addData($data);
        }
    }
    
    public function deleteOption($optionId) {
        $this->_getWriteAdapter()->delete(
            $this->getMainTable(),
            $this->_getWriteAdapter()->quoteInto('fee_option_id IN (?)', $optionId)
        );
        return $this;
    }
    
    public function getTitle($optionId, $storeId = 0) {
        $read = $this->_getReadAdapter();
        $select = $read->select()
            ->from($this->getMainTable(), 'title')
            ->where('fee_option_id = ?', $optionId)
            ->where('store_id = ?', $storeId);
        $title = $read->fetchOne($select);
        
        if (!$title && $storeId!=0) {
            $select = $read->select()
                ->from($this->getMainTable(), 'title')
                ->where('fee_option_id = ?', $optionId)
                ->where('store_id = 0');
            $title = $read->fetchOne($select);
        }        
        return $title;
    }
        
    public function getAllLanguage($optionId) {
        $read = $this->_getReadAdapter();
        $select = $read->select()
            ->from($this->getMainTable(), array('store_id', 'title'))
            ->where('fee_option_id = ?', $optionId);
        $result = $read->fetchAssoc($select);
        $languageData = array();
        foreach($result as $r) {
            $languageData[$r['store_id']] = $r['title'];
        }
        return $languageData;
    }   
}