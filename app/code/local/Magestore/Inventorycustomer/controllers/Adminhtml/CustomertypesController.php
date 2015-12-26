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
class Magestore_Inventorycustomer_Adminhtml_CustomertypesController extends Mage_Adminhtml_Controller_Action {

    /**
     * init layout and set active for current menu
     *
     * @return Magestore_Inventorycustomer_Adminhtml_CustomertypesController
     */
    protected function _initAction() {
        $this->loadLayout()
                ->_setActiveMenu('inventorycustomer')
                ->_addBreadcrumb(
                        Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager')
        );
        return $this;
    }

    /**
     * Customer types action
     */
    public function indexAction() {
        $this->_initAction()
                ->renderLayout();
    }

    public function vipcustomersgridAction() {
        $this->loadLayout();
        $this->getResponse()->setBody(
                $this->getLayout()->createBlock('inventorycustomer/adminhtml_customertypes_customergrid_vip')->toHtml()
        );
    }

    public function normalcustomersgridAction() {
        $this->loadLayout();
        $this->getResponse()->setBody(
                $this->getLayout()->createBlock('inventorycustomer/adminhtml_customertypes_customergrid_normal')->toHtml()
        );
    }

    public function notsatisfiedcustomersgridAction() {
        $this->loadLayout();
        $this->getResponse()->setBody(
                $this->getLayout()->createBlock('inventorycustomer/adminhtml_customertypes_customergrid_notsatisfied')->toHtml()
        );
    }

    public function changetypeAction() {
        $data = $this->getRequest()->getPost();
        if ($data) {
            $customerId = $data['customerId'];
            $customerType = $data['customerType'];

            $customer = Mage::getModel('customer/customer')->load($customerId);
            $customer->setData('customer_satisfaction_type', $customerType);

            try {
                $customer->save();

                $countCustomersBlockHtml = $this->getLayout()->createBlock('inventorycustomer/adminhtml_customertypes_customergrid_countcustomers')->toHtml();

                $result = array();
                $result['success'] = 1;
                $result['countCustomersBlockHtml'] = $countCustomersBlockHtml;
                $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
            } catch (Exception $e) {
                $jsonResult['success'] = 0;
                $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($jsonResult));
            }
        }
    }

    public function notesAction() {
        $this->loadLayout()
                ->renderLayout();
    }

    public function editnotesAction() {
        $data = $this->getRequest()->getPost();
        if ($data) {
            $customerId = $data['customerId'];
            $customerNotes = $data['customerNotes'];
            $customer = Mage::getModel('customer/customer')->load($customerId);
            $customer->setData('customer_notes', $customerNotes);
            
            try {
                $customer->save();
                $result = array();
                $result['success'] = 1;
                $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
            } catch (Exception $ex) {
                $result = array();
                $result['success'] = 0;
                $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
                Mage::log('Save notes failed, customerId = ' . $customerId);
            }
        }
    }

}
