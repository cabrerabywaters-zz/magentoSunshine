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
 * Inventoryreports Adminhtml Controller
 * 
 * @category    Magestore
 * @package     Magestore_Inventorycustomer
 * @author      Magestore Developer
 */
class Magestore_Inventorycustomer_Adminhtml_ManageinteractionsController extends Mage_Adminhtml_Controller_Action {

    /**
     * init layout and set active for current menu
     *
     * @return Magestore_Inventorycustomer_Adminhtml_TodolistController
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
        $this->_initAction()
                ->renderLayout();
    }

    public function gridAction() {
        $this->loadLayout();
        $this->getResponse()->setBody(
                $this->getLayout()->createBlock('inventorycustomer/adminhtml_manageinteractions_grid')->toHtml()
        );
    }
    
    /**
     * export grid item to CSV type
     */
    public function exportCsvAction()
    {
        $fileName   = 'manageinteractions.csv';
        $content    = $this->getLayout()
                           ->createBlock('inventorycustomer/adminhtml_manageinteractions_grid')
                           ->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }

}
