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
class Magestore_Inventorycustomer_Helper_Returningcustomers extends Mage_Core_Helper_Abstract {

    /**
     * Get requested time range
     * 
     * @param array $requestData
     * @return array
     */
    public function getTimeRange($requestData) {
        return Mage::helper('inventorycustomer')->getTimeRange($requestData);
    }

    /**
     * Get all customers (who have at least 1 order)
     * 
     * @return collection
     */
    public function getReturningCustomersCollection() {

        $customerCollection = Mage::getResourceModel('inventorycustomer/customer_collection')
                ->addNameToSelect()
                ->addAttributeToSelect('number_of_orders')
                ->addAttributeToSelect('customer_satisfaction_type')
                ->addAttributeToSort('number_of_orders', 'DESC')
                ->joinAttribute('billing_telephone', 'customer_address/telephone', 'default_billing', null, 'left')
                ->addAttributeToFilter('number_of_orders', array('gteq' => 2));

        return $customerCollection;
    }

    public function getCustomersHaveCompleteOrder($requestData) {
        Mage::getSingleton('inventorycustomer/session')->setData('dateFrom', null);
        Mage::getSingleton('inventorycustomer/session')->setData('dateto', null);

        $timeRange = $this->getTimeRange($requestData);
        $datefrom = $timeRange['from'];
        $dateto = $timeRange['to'];

        $formattedDateFrom = date('Y-m-d H:i:s', strtotime($datefrom));
        $formattedDateTo = date('Y-m-d H:i:s', strtotime($dateto));

        Mage::getSingleton('inventorycustomer/session')->setData('dateFrom', $datefrom);
        Mage::getSingleton('inventorycustomer/session')->setData('dateTo', $dateto);

        $customersCollection = $this->getReturningCustomersCollection();
        $customersCollection->getSelect()
                ->join(
                        array('order' => $customersCollection->getTable('sales/order')), "order.customer_id = e.entity_id", array('order_id' => 'order.entity_id', 'order_created_at' => 'order.created_at', 'order.total_qty_ordered', 'order.grand_total'));
        $customersCollection->getSelect()->where("status = 'complete'");
        $customersCollection->getSelect()->where('order.created_at >= "' . $formattedDateFrom . '" AND order.created_at <= "' . $formattedDateTo . '"');
        $customersCollection->getSelect()->group(array('e.entity_id'));

        return $customersCollection;
    }

    /**
     * Get all orders of a customer
     * 
     * @param type $customerId
     * @return type
     */
    public function getReturningCustomerOrders($customerId) {
        $customerOrders = Mage::getModel('sales/order')->getCollection()
                ->addFieldToSelect(array('entity_id', 'created_at', 'status'))
                ->addFieldToFilter('customer_id', $customerId)
                ->addFieldToFilter('status', array('like' => 'complete'));

        $customerOrders->getSelect()->order('created_at DESC');

        return $customerOrders;
    }

    public function getFormattedTimeRange($fromDate, $toDate, $totalOrders, $html) {
        $from = strtotime($fromDate);
        $to = strtotime($toDate);

        // Calculate average time of order
        if ($totalOrders > 1) {
            $diff = abs(($from - $to) / ($totalOrders - 1));
        } else {
            $diff = abs($from - $to);
        }
        // Calculate year, month, day
        $years = floor($diff / (365 * 60 * 60 * 24));
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));

        // Return suitable time format
        if ($years == 0 && $months == 0 && $days == 0) {
            $html .= "1 day";
        } elseif ($years == 0 && $months > 0 && $days > 0) {
            $html .= $months . " months, " . $days . " days";
        } elseif ($years > 0 && $months == 0 && $days > 0) {
            $html .= $years . " years, " . $days . " days";
        } elseif ($years > 0 && $months > 0 && $days == 0) {
            $html .= $years . " years, " . $months . " months, ";
        } elseif ($years == 0 && $months == 0 && $days > 0) {
            $html .= $days . " days";
        } elseif ($years == 0 && $months > 0 && $days == 0) {
            $html .= $months . " months";
        } elseif ($years > 0 && $months == 0 && $days == 0) {
            $html .= $years . " years";
        } else {
            $html .= $years . " years, " . $months . " months, " . $days . " days";
        }
        return $html;
    }

    public function getCustomerOrderAverageRatio() {
        $customerCollection = $this->getReturningCustomersCollection();

        foreach ($customerCollection as $customer) {
            $customerOrders = $this->getReturningCustomerOrders($customer->getId());

            $customerOrders->getSelect()->order('created_at', 'DESC');

            $totalOrders = $customerOrders->getSize();
            if ($totalOrders > 1) {
                $firstOrderDate = $customerOrders->getFirstItem()->getData('created_at');
                $lastOrderDate = $customerOrders->getLastItem()->getData('created_at');
            }
        }
    }

}
