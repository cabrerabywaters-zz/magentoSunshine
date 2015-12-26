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
class Magestore_Inventorycustomer_Adminhtml_TodolistController extends Mage_Adminhtml_Controller_Action {

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
                $this->getLayout()->createBlock('inventorycustomer/adminhtml_todolist_grid')->toHtml()
        );
    }

    public function marktodoisdoneAction() {
        $data = $this->getRequest()->getPost();
        $jsonResult = array();
        if ($data) {
            $interactionId = $data['interaction_id'];

            $customerInteraction = Mage::getModel('inventorycustomer/customerinteraction')->load($interactionId);
            $customerInteraction->setIsDone(1);

            try {
                $customerInteraction->save();

                $jsonResult['success'] = 1;
                $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($jsonResult));
            } catch (Exception $e) {
                $jsonResult['success'] = 0;
                $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($jsonResult));
            }
        }
    }

    public function syncAction() {
        $page = $this->getRequest()->getParam('page');

        if ($page) {
            $i = $page;
        } else {
            $i = 1;
        }
        $customerCollection = Mage::getResourceModel('inventorycustomer/customer_collection')
                ->addAttributeToSelect('customer_satisfaction_type')
                ->addAttributeToSelect('number_of_orders');
        $customerCollection->getSelect()
                ->join(
                        array('order' => $customerCollection->getTable('sales/order')), "order.customer_id = e.entity_id", array('order_created_at' => 'order.created_at', 'order.total_qty_ordered', 'order.grand_total'));
        $customerCollection->getSelect()->where("status LIKE 'complete'");
        $customerCollection->getSelect()->columns(array(
            'number_orders' => 'IFNULL(count(order.entity_id), 0)',
        ));
        $customerCollection->getSelect()->group(array('e.entity_id'));
        
        $customerClone = clone $customerCollection;
        $customerClone->getSelect()->limit(500, ($i - 1) * 500 + 1);

        foreach ($customerClone as $customer) {
            $numberOrders = $customer->getData('number_orders');
            $customer->setNumberOfOrders($numberOrders);
            if ($numberOrders >= 5) {
                $customer->setData('customer_satisfaction_type', 1);
            } else {
                $customer->setData('customer_satisfaction_type', 2);
            }
            
            try {
                $customer->save();
            } catch (Exception $ex) {
                Mage::log("Customer with error: " . $customer->getId());
            }
        }
        
        $i = $i + 1;
        if ($i <= ceil($customerCollection->getSize() / 500)) {
            $url = Mage::helper('adminhtml')->getUrl('*/*/*', array('page' => $i));
            echo '<script type="text/javascript">window.location = "' . $url . '"</script>';
            return;
        }
    }
    
    /**
     * export grid item to CSV type
     */
    public function exportCsvAction()
    {
        $fileName   = 'todolist.csv';
        $content    = $this->getLayout()
                           ->createBlock('inventorycustomer/adminhtml_todolist_grid')
                           ->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }

}
