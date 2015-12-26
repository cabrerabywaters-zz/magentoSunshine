<?php

/**
 * Magestore
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the Magestore.com license that is
 * available through the world-wide-web at this URL:
 * http://www.magestore.com/license-agreement.html
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category    Magestore
 * @package     Magestore_Inventorycustomer
 * @copyright   Copyright (c) 2012 Magestore (http://www.magestore.com/)
 * @license     http://www.magestore.com/license-agreement.html
 */

/**
 * Inventorycustomer Helper
 * 
 * @category    Magestore
 * @package     Magestore_Inventorycustomer
 * @author      Magestore Developer
 */
class Magestore_Inventorycustomer_Helper_Customertypes extends Mage_Core_Helper_Abstract {

    public function getCustomers() {
        $customersCollection = Mage::getResourceModel('inventorycustomer/customer_collection')
                ->addNameToSelect()
                ->addAttributeToSelect('email')
                ->addAttributeToSelect('customer_notes')
                ->addAttributeToSelect('customer_satisfaction_type')
                ->joinAttribute('billing_telephone', 'customer_address/telephone', 'default_billing', null, 'left')
                ->addAttributeToFilter('number_of_orders', array('gteq' => 1));

        return $customersCollection;
    }
    
    public function getCustomersHaveCompleteOrder() {
        $customersCollection = $this->getCustomers();
        $customersCollection->getSelect()
                ->join(
                        array('order' => $customersCollection->getTable('sales/order')), "order.customer_id = e.entity_id", array('order_created_at' => 'order.created_at', 'order.total_qty_ordered', 'order.grand_total'));
        $customersCollection->getSelect()->where("status = 'complete'");
        $customersCollection->getSelect()->columns(array(
            'last_order_date' => 'max(order.created_at)',
            'number_orders' => 'IFNULL(count(order.entity_id), 0)',
            'number_items' => 'IFNULL(sum(order.total_qty_ordered), 0)',
            'total_value' => 'IFNULL(sum(order.grand_total), 0)'
        ));
        $customersCollection->getSelect()->group(array('e.entity_id'));
        
        return $customersCollection;
    }

    /**
     * Get all vip customers
     */
    public function getVipCustomers() {
        $vipCustomersCollection = $this->getCustomersHaveCompleteOrder();
        $vipCustomersCollection->addAttributeToFilter('customer_satisfaction_type', array('eq' => 1));
        return $vipCustomersCollection;
    }

    /**
     * Get all normal customers
     */
    public function getNormalCustomers() {
        $normalCustomersCollection = $this->getCustomersHaveCompleteOrder();
        $normalCustomersCollection->addAttributeToFilter('customer_satisfaction_type', array('eq' => 2));
        return $normalCustomersCollection;
    }

    /**
     * Get all not satisfied customers
     */
    public function getNotSatisfiedCustomers() {
        $notsatisfiedCustomersCollection = $this->getCustomersHaveCompleteOrder();
        $notsatisfiedCustomersCollection->addAttributeToFilter('customer_satisfaction_type', array('eq' => 3));
        return $notsatisfiedCustomersCollection;
    }

}
