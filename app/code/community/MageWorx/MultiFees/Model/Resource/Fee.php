<?php
/**
 * MageWorx
 * Multi Fees Extension
 *
 * @category   MageWorx
 * @package    MageWorx_MultiFees
 * @copyright  Copyright (c) 2015 MageWorx (http://www.mageworx.com/)
 */

class MageWorx_MultiFees_Model_Resource_Fee extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct() {
        $this->_init('mageworx_multifees/fee', 'fee_id');
    }
    
    protected function _afterLoad(Mage_Core_Model_Abstract $object) {
        $read = $this->_getReadAdapter();
        
        // load stories
        $select = $read->select()
                ->from($this->getTable('mageworx_multifees/store'))
                ->where('fee_id = ?', $object->getId());
        $data = $read->fetchAll($select);
        if ($data) {
            $storesArray = array();
            foreach ($data as $row) {
                $storesArray[] = $row['store_id'];
            }
            $object->setData('store_id', $storesArray);
        }
        
        // load names and descriptions
        $select = $read->select()
                ->from($this->getTable('mageworx_multifees/language_fee'))
                ->where('fee_id = ?', $object->getId());
        $data = $read->fetchAll($select);
        if ($data) {
            $namesArray = array();
            $descriptionsArray = array();
            $customerMessageTitlesArray = array();
            $dateFieldTitlesArray = array();
            foreach ($data as $row) {
                if ($row['store_id']==0) {
                    $object->setTitle($row['title'])
                        ->setDescription($row['description'])
                        ->setCustomerMessageTitle($row['customer_message_title'])
                        ->setDateFieldTitle($row['date_field_title']);
                } else {
                    $namesArray[$row['store_id']] = $row['title'];
                    $descriptionsArray[$row['store_id']] = $row['description'];
                    $customerMessageTitlesArray[$row['store_id']] = $row['customer_message_title'];
                    $dateFieldTitlesArray[$row['store_id']] = $row['date_field_title'];
                }    
            }
            $object->setStoreNames($namesArray)
                ->setStoreDescriptions($descriptionsArray)
                ->setStoreCustomerMessageTitles($customerMessageTitlesArray)
                ->setStoreDateFieldTitles($dateFieldTitlesArray);
        }
                
        // prepare payments or shippings
        if ($object->getSalesMethods()) {
            $salesMethods = explode(',', $object->getSalesMethods());
            if ($object->isPaymentFee()) {
                $object->setPayments($salesMethods);
            } elseif ($object->isShippingFee()) {
                $object->setShippings($salesMethods);
            }
        }
        
        return parent::_afterLoad($object);
    }    
    
    protected function _beforeDelete(Mage_Core_Model_Abstract $object) {
        $options = Mage::getResourceSingleton('mageworx_multifees/option')->getOptions($object->getId());
        if ($options) {
            $optionIds = array_keys($options);
            $helper = Mage::helper('mageworx_multifees');
            foreach ($optionIds as $optionId) {
                $helper->removeOptionFile($optionId);
            }
        }
        return parent::_beforeDelete($object);
    }
    
}