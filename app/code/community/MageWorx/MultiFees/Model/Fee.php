<?php
/**
 * MageWorx
 * Multi Fees Extension
 *
 * @category   MageWorx
 * @package    MageWorx_MultiFees
 * @copyright  Copyright (c) 2015 MageWorx (http://www.mageworx.com/)
 */

class MageWorx_MultiFees_Model_Fee extends Mage_SalesRule_Model_Rule //Mage_Rule_Model_Rule //Mage_Core_Model_Abstract
{
    const CART_FEE = 1;
    const PAYMENT_FEE = 2;
    const SHIPPING_FEE = 3;
    
    protected $_eventPrefix = 'multifees_rule';
    
    public function _construct() {
        parent::_construct();
	$this->_init('mageworx_multifees/fee');
        $this->setIdFieldName('fee_id');
    }

    /**
     * @return bool
     */
    public function isCartFee() {
        return $this->getType()==self::CART_FEE;
    }

    /**
     * @return bool
     */
    public function isPaymentFee() {
        return $this->getType()==self::PAYMENT_FEE;
    }

    /**
     * @return bool
     */
    public function isShippingFee() {
        return $this->getType()==self::SHIPPING_FEE;
    }

    /**
     * @return false|Mage_Core_Model_Abstract|Mage_SalesRule_Model_Rule_Condition_Combine
     */
    public function getConditionsInstance() {
        return Mage::getModel('mageworx_multifees/fee_condition_combine');
    }

    /**
     * @return false|Mage_Core_Model_Abstract|Mage_SalesRule_Model_Rule_Condition_Product_Combine
     */
    public function getActionsInstance() {
        return Mage::getModel('mageworx_multifees/fee_condition_product_combine');
    }

    /**
     * @return Mage_Rule_Model_Abstract|void
     */
    protected function _beforeSave() {
        parent::_beforeSave();
        if (is_array($this->getCustomerGroupIds())) {
            $this->setCustomerGroupIds(join(',', $this->getCustomerGroupIds()));
        }        
    }

    /**
     * standart magento _afterSave
     * @return $this|Mage_SalesRule_Model_Rule
     */
    protected function _afterSave() {
        $this->cleanModelCache();
        Mage::dispatchEvent('model_save_after', array('object'=>$this));
        Mage::dispatchEvent($this->_eventPrefix.'_save_after', $this->_getEventData());
        return $this;
    }

    /**
     * @return array|mixed
     */
    public function getCustomerGroupIds() {
        $customerGroupIds = $this->getData('customer_group_ids');
        if (is_null($customerGroupIds) || $customerGroupIds==='') return array();
        if (is_string($customerGroupIds)) $this->setData('customer_group_ids', explode(',', $customerGroupIds));        
        return $this->getData('customer_group_ids');
    }

    /**
     * @param bool $setChecked
     * @param int $addressId
     * @return mixed
     */
    public function getOptions($setChecked = false, $addressId = 0) {
        $collection = Mage::getResourceModel('mageworx_multifees/option_collection')
                ->addFeeFilter($this->getFeeId())
                ->addStoreLanguage($this->getStoreId())
                ->sortByPosition(Varien_Data_Collection::SORT_ORDER_ASC)
                ->load();
        
        if ($setChecked) $this->_setCheckedFeeOption($collection, $addressId);
        return $collection->getItems();
    }

    /**
     * @param $collection
     * @param int $addressId
     */
    private function _setCheckedFeeOption($collection, $addressId = 0) {
        $detailsFees = Mage::helper('mageworx_multifees')->getQuoteDetailsMultifees($addressId);
        
        if (!isset($detailsFees[$this->getFeeId()]) && !$this->isCartFee()) return;
        $items = $collection->getItems();
        if ($items) {
            foreach ($items as $item) {
                if (isset($detailsFees[$this->getFeeId()]['options'][$item->getId()])) {
                    $item->setIsDefault(1);
                } else {
                    $item->setIsDefault(0);
                }
            }
        }
    }    

    /**
     * counter product in cart
     * @param $address
     * @return $this
     */
    public function addAllQuoteItemQty($address) {
        if ($this->getIsOnetime()==0) {
            foreach ($address->getAllItems() as $item) {
                $this->addFoundQuoteItemQty($item, $address->getId());
            }
        }
        return $this;
    }

    /**
     * @param $quoteItem
     * @param $addressId
     * @return $this
     */
    public function addFoundQuoteItemQty($quoteItem, $addressId) {
        if ($this->getIsOnetime()==0) {
            if ($quoteItem->getParentItem()) $quoteItem = $quoteItem->getParentItem();
            $foundItemIds = $this->getFoundItemIds();
            if ($foundItemIds && in_array($quoteItem->getId(), $foundItemIds)) return $this;
            if (is_null($foundItemIds)) $foundItemIds = array();
            $foundItemIds[] = $quoteItem->getId();
            $this->setFoundItemIds($foundItemIds);        
            $this->setFoundQty(intval($this->getFoundQty($addressId)) + $quoteItem->getQty(), $addressId);
        }
        return $this;
    }

    /**
     * @param $qty
     * @param int $addressId
     */
    public function setFoundQty($qty, $addressId = 0) {
        $foundQty = $this->getData('found_qty');
        if (!is_array($foundQty)) $foundQty = array();
        $foundQty[$addressId] = $qty;
        $this->setData('found_qty', $foundQty);
    }

    /**
     * @param int $addressId
     * @return int
     */
    public function getFoundQty($addressId = 0) {
        if ($this->getIsOnetime()) return 1;
        $foundQty = $this->getData('found_qty');
        if (isset($foundQty[$addressId])) return $foundQty[$addressId];
        return 0;
    }
   
    
}