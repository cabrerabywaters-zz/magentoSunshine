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
class Magestore_Inventorycustomer_Helper_Allcustomers extends Mage_Core_Helper_Abstract {

    /**
     * Get all customers in database
     * 
     * @return collection
     */
    public function getCustomers() {
        $customersCollection = Mage::getResourceModel('inventorycustomer/customer_collection')
                ->addNameToSelect()
                ->addAttributeToSelect('email')
                ->addAttributeToSelect('customer_satisfaction_type')
                ->addAttributeToSelect('customer_notes')
                ->joinAttribute('billing_telephone', 'customer_address/telephone', 'default_billing', null, 'left')
                ->addAttributeToFilter('number_of_orders', array('gteq' => 1));

        return $customersCollection;
    }

    /**
     * Get collection of customers who have complete order
     * 
     * @return collection
     */
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
     * Get first name, middle name, last name from full name
     * 
     * @param string $fullName
     * @return array
     */
    public function separateToFirstMiddleLastName($fullName) {
        $realName = $this->removeRedundantSpaces($fullName);
        $wordArray = explode(' ', $realName);
        $middleName = " ";
        if (count($wordArray) > 2) {
            reset($wordArray);
            $lastName = $wordArray[key($wordArray)];
            end($wordArray);
            $firstName = $wordArray[key($wordArray)];
            reset($wordArray);
            array_shift($wordArray);
            array_pop($wordArray);
            if (count($wordArray) >= 1) {
                $middleName = implode(" ", $wordArray);
            }
        }
        return array($firstName, $middleName, $lastName);
    }
    
    /**
     * Get first name, last name from full name
     * 
     * @param string $fullName
     * @return array
     */
    public function separateToFirstAndLastName($fullName) {
        $realName = $this->removeRedundantSpaces($fullName);
        $wordArray = explode(' ', $realName);
        if (count($wordArray) > 2) {
            reset($wordArray);
            $firstName = $wordArray[key($wordArray)];
            array_shift($wordArray);
            if (count($wordArray) >= 1) {
                $lastName = implode(" ", $wordArray);
            }
        } else {
            $firstName = $realName;
            $lastName = " ";
        }
        return array($firstName, $lastName);
    }

    /**
     * Remove redundant spaces from full name
     * 
     * @param string $fullName
     * @return string
     */
    protected function removeRedundantSpaces($fullName) {
        $result = NULL;
        for ($i = 0; $i < strlen($fullName); $i++) {
            if (substr($fullName, $i, 1) != ' ') {
                $result .= trim(substr($fullName, $i, 1));
            } else {
                while (substr($fullName, $i, 1) == ' ') {
                    $i++;
                }
                $result .= ' ';
                $i--;
            }
        }
        return trim($result);
    }

}
