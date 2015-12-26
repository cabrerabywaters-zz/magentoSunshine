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
 * Inventoryreports Adminhtml Controller
 * 
 * @category    Magestore
 * @package     Magestore_Inventorycustomer
 * @author      Magestore Developer
 */
class Magestore_Inventorycustomer_Adminhtml_ReturningcustomersController extends Mage_Adminhtml_Controller_Action {

    /**
     * init layout and set active for current menu
     *
     * @return Magestore_Inventorycustomer_Adminhtml_ReturningcustomersController
     */
    protected function _initAction() {
        $this->loadLayout()
                ->_setActiveMenu('inventorycustomer')
                ->_addBreadcrumb(
                        Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager')
        );
        return $this;
    }

    public function indexAction() {
        $defaultTo = date('Y-m-d');
        $defaultFrom = date('Y-m-d', strtotime("-3 months", strtotime($defaultTo)));
        if (!$this->getRequest()->getParam('top_filter')) {
            $top_filter = '&date_from=' . $defaultFrom . '&date_to=' . $defaultTo;
            $top_filter = base64_encode($top_filter);
            $this->getRequest()->setParam('top_filter', $top_filter);
        }

        $this->_initAction()
                ->renderLayout();
    }

    public function gridAction() {
        $this->loadLayout();
        $this->getResponse()->setBody(
                $this->getLayout()->createBlock('inventorycustomer/adminhtml_returningcustomers_grid')->toHtml()
        );
    }

}
