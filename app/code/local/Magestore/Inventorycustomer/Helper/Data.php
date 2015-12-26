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
 * Inventoryreports Helper
 * 
 * @category    Magestore
 * @package     Magestore_Inventoryreports
 * @author      Magestore Developer
 */
class Magestore_Inventorycustomer_Helper_Data extends Mage_Core_Helper_Abstract {

    /**
     * Get requested time range
     * 
     * @param array $requestData
     * @return array
     */
    public function getTimeRange($requestData) {
        $datefrom = '';
        $dateto = '';
        //get time range
        if (isset($requestData['date_from'])) {
            $datefrom = $requestData['date_from'];
        } else {
            $now = now();
            $datefrom = date("Y-m-d", Mage::getModel('core/date')->timestamp($now));
        }
        if (isset($requestData['date_to'])) {
            $dateto = $requestData['date_to'];
        } else {
            $now = now();
            $dateto = date("Y-m-d", Mage::getModel('core/date')->timestamp($now));
        }
        $datefrom = $datefrom . ' 00:00:00';
        $dateto = $dateto . ' 23:59:59';
        return array('from' => $datefrom, 'to' => $dateto);
    }

}
