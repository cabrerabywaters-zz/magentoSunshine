<?php
/**
 * MageWorx
 * Multi Fees Extension
 *
 * @category   MageWorx
 * @package    MageWorx_MultiFees
 * @copyright  Copyright (c) 2015 MageWorx (http://www.mageworx.com/)
 */

class MageWorx_MultiFees_Model_Resource_Fee_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    
    public function _construct() {
        $this->_init('mageworx_multifees/fee');
    }

    public function addLabels($storeId = null) {
        if (is_null($storeId)) $storeId = Mage::app()->getStore()->getId();
        
        if ($storeId!=0) {
            $this->getSelect()->joinLeft(array('language_fee_default' => $this->getTable('mageworx_multifees/language_fee')), 'main_table.fee_id = language_fee_default.fee_id AND language_fee_default.store_id = 0')
                ->joinLeft(array('language_fee' => $this->getTable('mageworx_multifees/language_fee')), 'main_table.fee_id = language_fee.fee_id AND language_fee.store_id = '.$storeId,
                        array('title'=>"IF(language_fee.title!='', language_fee.title, language_fee_default.title)", 
                            'description'=>"IF(language_fee.description!='', language_fee.description, language_fee_default.description)",
                            'customer_message_title'=>"IF(language_fee.customer_message_title!='', language_fee.customer_message_title, language_fee_default.customer_message_title)",
                            'date_field_title'=>"IF(language_fee.date_field_title!='', language_fee.date_field_title, language_fee_default.date_field_title)",
                        ));
        } else {
            $this->getSelect()->joinLeft(array('language_fee_default' => $this->getTable('mageworx_multifees/language_fee')), 'main_table.fee_id = language_fee_default.fee_id AND language_fee_default.store_id = 0', array('title', 'description', 'customer_message_title', 'date_field_title'));
        }
        return $this;
    }

    public function addStoresVisibility()
    {
        $feeIds = $this->getColumnValues('fee_id');

        $feesStores = array();
        if (sizeof($feeIds) > 0) {
            $select = $this->getConnection()->select()
                ->from($this->getTable('mageworx_multifees/store'), array('store_id', 'fee_id'))
                ->where('fee_id IN(?)', $feeIds);
            $feeRaw = $this->getConnection()->fetchAll($select);

            foreach ($feeRaw as $fee) {
                if (!isset($feesStores[$fee['fee_id']])) {
                    $feesStores[$fee['fee_id']] = array();
                }

                $feesStores[$fee['fee_id']][] = $fee['store_id'];
            }
        }

        foreach ($this as $item) {
            if (isset($feesStores[$item->getId()])) {
                $item->setStores($feesStores[$item->getId()]);
            } else {
                $item->setStores(array());
            }
        }

        return $this;
    }

    public function addStoreFilter($storeId = null, $withDefault = true) {
        if (is_null($storeId)) {
            $storeId = Mage::app()->getStore()->getId();
        }
        $this->getSelect()->join(array('store_table' => $this->getTable('mageworx_multifees/store')), 'main_table.fee_id = store_table.fee_id', array())
            ->where('store_table.store_id IN (?)', ($withDefault && $storeId!=0 ? array(0, $storeId) : $storeId))
            ->group('main_table.fee_id');
        return $this;
    }
    
    public function addStatusFilter() {
        $this->getSelect()->where('main_table.status = 1');
        return $this;
    }
    
    public function addTypeFilter($types = array()) {
        if ($types) $this->getSelect()->where('main_table.type IN (?)', $types);
        return $this;
    }
    
    public function addRequiredFilter($required = 0) {
        if ($required) $this->getSelect()->where('main_table.required = 1');
        return $this;
    }
    
    public function addHiddenFilter($hidden = 0) {
        if ($hidden==1) $this->getSelect()->where('main_table.input_type = 4'); // hidden
        if ($hidden==2) $this->getSelect()->where('main_table.input_type <> 4'); // no hidden
        if ($hidden==3) $this->getSelect()->where('main_table.input_type = 4 OR main_table.input_type = 5'); // hidden + notice
        return $this;
    }
    
    public function addIsDefaultFilter($isDefault = 0) {
        if ($isDefault) {
            $this->getSelect()->join(array('option_table' => $this->getTable('mageworx_multifees/option')), 'main_table.fee_id = option_table.fee_id', array())
                ->where('option_table.is_default = 1');
        }
        return $this;
    }
        
    public function addSortOrder() {
        $this->getSelect()->order('main_table.sort_order', Varien_Data_Collection::SORT_ORDER_ASC);        
        return $this;
    }
}