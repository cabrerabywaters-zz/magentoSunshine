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
 * @package     Magestore_Inventorysupplyneeds
 * @copyright   Copyright (c) 2012 Magestore (http://www.magestore.com/)
 * @license     http://www.magestore.com/license-agreement.html
 */

/**
 * Inventoryreports Observer Model
 * 
 * @category    Magestore
 * @package     Magestore_Inventorycustomer
 * @author      Magestore Developer
 */
class Magestore_Inventorycustomer_Model_Observer {

    /**
     * Change customer type to VIP if number of orders >= 5 (or value from config)
     * 
     * @param type $observer
     */
    public function salesOrderPlaceAfter($observer) {
        $order = $observer->getOrder();
        $customerId = $order->getCustomerId();

        $customer = Mage::getModel('customer/customer')->load($customerId);
        $numberOfOrders = $customer->getData('number_of_orders');
        if (!$numberOfOrders) {
            $numberOfOrders = 0;
        }
        $numberOfOrdersInConfig = Mage::getStoreConfig('inventoryplus/customer/minimum_orders_to_be_vip');
        if ($numberOfOrders >= $numberOfOrdersInConfig - 1) {
            $customer->setData('customer_satisfaction_type', 1);
        }

        $customer->setData('number_of_orders', $numberOfOrders + 1);

        try {
            $customer->save();
        } catch (Exception $ex) {
            Mage::log("salesOrderPlaceAfter error: " . $ex);
        }
    }

}
