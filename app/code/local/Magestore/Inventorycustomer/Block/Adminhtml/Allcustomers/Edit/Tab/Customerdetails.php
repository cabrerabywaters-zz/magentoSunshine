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
 * @package     Magestore_Inventory
 * @copyright   Copyright (c) 2012 Magestore (http://www.magestore.com/)
 * @license     http://www.magestore.com/license-agreement.html
 */

/**
 * Inventory Customer Edit Tab CustomerDetails
 * 
 * @category    Magestore
 * @package     Magestore_Inventory
 * @author      Magestore Developer
 */
class Magestore_Inventorycustomer_Block_Adminhtml_Allcustomers_Edit_Tab_Customerdetails extends Mage_Adminhtml_Block_Template {

    public function __construct() {
        $this->setTemplate('inventorycustomer/allcustomers/edit/tab/customerdetails.phtml');
    }

    /**
     * Get customer information from registry
     * 
     * @return type
     */
    public function getCustomer() {
        $customerId = $this->getRequest()->getParam("id");

        // save customerId into session for further use
        Mage::getSingleton("inventorycustomer/session")->setData("customerId", $customerId);

        $customersCollection = Mage::helper('inventorycustomer/allcustomers')->getCustomers();
        $customersCollection->getSelect()
                ->joinLeft(
                        array('order' => $customersCollection->getTable('sales/order')), "order.customer_id = e.entity_id", array('order.created_at', 'order.total_qty_ordered', 'order.grand_total', 'order.served_by_staff'));
        $customersCollection->getSelect()->where("status = 'complete'");
        $customersCollection->getSelect()->columns(array(
            'last_order_date' => 'max(order.created_at)',
            'number_orders' => 'IFNULL(count(order.entity_id), 0)',
            'number_items' => 'IFNULL(sum(order.total_qty_ordered), 0)',
            'total_value' => 'IFNULL(sum(order.grand_total), 0)'
        ));
        $customersCollection->getSelect()->where("`e`.`entity_id`= $customerId");
        $customersCollection->getSelect()->group(array('e.entity_id'));

        $model = $customersCollection->getFirstItem();
        return $model;
    }

    /**
     * Get customer address
     * 
     * @return type
     */
    public function getCustomerBillingAddress() {
        $customerId = $this->getRequest()->getParam("id");
        $customer = Mage::getModel('customer/customer')->load($customerId);
        $customerAddress = $customer->getPrimaryBillingAddress();
        if ($customerAddress) {
            return $customerAddress->getData('street') . ", " . $customerAddress->getData('city');
        }
        return 'N/A';
    }

    /**
     * Create recent orders block
     * 
     * @return type
     */
    public function getRecentOrdersBlock() {
        $recentOrdersBlockHtml = $this->getLayout()->createBlock('inventorycustomer/adminhtml_allcustomers_edit_tab_customerdetails_recentorders')->toHtml();
        return $recentOrdersBlockHtml;
    }

    /**
     * Get email of staff who served last order
     * 
     * @return string
     */
    public function getServedStaff() {
        $userId = $this->getCustomer()->getData('served_by_staff');
        $user = Mage::getModel('admin/user')->load($userId);
        if ($user->getId()) {
            return $user->getEmail();
        }

        // If no admin found
        return "N/A";
    }

    public function getInteractionHistoryBlock() {
        $interactionHistoryBlockHtml = $this->getLayout()->createBlock('inventorycustomer/adminhtml_allcustomers_edit_tab_customerdetails_interactionhistory')->toHtml();
        return $interactionHistoryBlockHtml;
    }

}
