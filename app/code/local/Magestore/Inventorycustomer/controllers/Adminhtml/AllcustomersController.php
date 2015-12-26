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
class Magestore_Inventorycustomer_Adminhtml_AllcustomersController extends Mage_Adminhtml_Controller_Action {

    /**
     * init layout and set active for current menu
     *
     * @return Magestore_Inventorycustomer_Adminhtml_AllcustomersController
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
     * All customers action
     */
    public function indexAction() {
        $this->_initAction()
                ->renderLayout();
    }

    /**
     * All customers grid action
     */
    public function gridAction() {
        $this->loadLayout();
        $this->getResponse()->setBody(
                $this->getLayout()->createBlock('inventorycustomer/adminhtml_allcustomers_grid')->toHtml()
        );
    }

    /**
     * View and edit customer information
     */
    public function editAction() {
        $customerId = $this->getRequest()->getParam("id");
        $customersCollection = Mage::helper('inventorycustomer/allcustomers')->getCustomers();
        $customersCollection->getSelect()
                ->join(
                        array('order' => $customersCollection->getTable('sales/order')), "order.customer_id = e.entity_id", array('order.created_at', 'order.total_qty_ordered', 'order.grand_total'));
        $customersCollection->getSelect()->columns(array(
            'last_order_date' => 'max(order.created_at)',
            'number_orders' => 'IFNULL(count(order.entity_id), 0)',
            'number_items' => 'IFNULL(sum(order.total_qty_ordered), 0)',
            'total_value' => 'IFNULL(sum(order.grand_total), 0)'
        ));
        $customersCollection->getSelect()->where("`e`.`entity_id`= $customerId");
        $customersCollection->getSelect()->group(array('e.entity_id'));

        $model = $customersCollection->getFirstItem();
        if ($model->getId() || $customerId == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }

            Mage::register("inventorycustomer_customer_data", $model);

            $this->loadLayout();
            $this->_addContent($this->getLayout()
                            ->createBlock('inventorycustomer/adminhtml_allcustomers_edit'))
                    ->_addLeft($this->getLayout()
                            ->createBlock('inventorycustomer/adminhtml_allcustomers_edit_tabs')
            );
            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('inventorycustomer')->__('Customer does not exist'));
            $this->_redirect('*/*/');
        }
    }

    /**
     * Search for customer using Ajax
     * 
     */
    public function searchcustomerAction() {
        $searchValue = $this->getRequest()->getParam('search_value');
        Mage::getSingleton("inventorycustomer/session")->setData("searchValue", $searchValue);

        $result = array();
        $result['success'] = 1;
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }

    /**
     * Save customer with only supported field
     * 
     * @return type
     */
    public function saveAction() {
        if ($data = $this->getRequest()->getPost()) {
            $customerId = $this->getRequest()->getParam('id');
            $customerSatisfactionType = $data['customer_satisfaction_type'];
            $customerNotes = $data['customer_notes'];

            $customer = Mage::getModel('customer/customer')->load($customerId);
            $customer->setData('customer_satisfaction_type', $customerSatisfactionType);
            $customer->setData('customer_notes', $customerNotes);

            try {
                $customer->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('inventorycustomer')->__('Customer was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $customer->getId()));
                    return;
                }
                
                $this->_redirect('*/*/edit', array('id' => $customer->getId()));
                return;
            } catch (Exception $ex) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('inventorycustomer')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
    }

    /**
     * Open popup to add new customer interaction
     * 
     */
    public function newinteractionAction() {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Add new interaction with customer
     * 
     */
    public function addinteractionAction() {
        $data = $this->getRequest()->getPost();
        $jsonResult = array();
        if ($data) {
            $action = $data['action'];
            $result = $data['result'];
            $nextAction = $data['next_action'];
            $remindAt = $data['remind_at'];
            $isDone = 0;

            // get customerId from session
            $customerId = Mage::getSingleton("inventorycustomer/session")->getData('customerId');
            $newCustomerInteraction = Mage::getModel('inventorycustomer/customerinteraction');
            $newCustomerInteraction->setCustomerId($customerId);
            $newCustomerInteraction->setAction($action);
            $newCustomerInteraction->setResult($result);
            $newCustomerInteraction->setNextAction($nextAction);
            $newCustomerInteraction->setRemindAt($remindAt);
            $newCustomerInteraction->setIsDone($isDone);

            try {
                if ($newCustomerInteraction->getCreatedAt() == NULL) {
                    $newCustomerInteraction->setCreatedAt(now());
                }
                $newCustomerInteraction->save();

                $jsonResult['success'] = 1;
                $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($jsonResult));
            } catch (Exception $e) {
                $jsonResult['success'] = 0;
                $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($jsonResult));
            }
        }
    }

    public function interactionhistorygridAction() {
        $this->loadLayout();
        $this->getResponse()->setBody(
                $this->getLayout()->createBlock('inventorycustomer/adminhtml_allcustomers_edit_tab_customerdetails_interactionhistory')->toHtml()
        );
    }
    
    public function recentordersgridAction() {
        $this->loadLayout();
        $this->getResponse()->setBody(
                $this->getLayout()->createBlock('inventorycustomer/adminhtml_allcustomers_edit_tab_customerdetails_recentorders')->toHtml()
        );
    }

    /**
     * Inline editting on grid
     */
    public function updatefieldAction() {
        $customerId = (int) $this->getRequest()->getParam('id');
        $newValue = $this->getRequest()->getParam('value');

        $result = Mage::helper('inventorycustomer/allcustomers')->separateToFirstAndLastName($newValue);
        list($firstName, $lastName) = $result;
        $columnIndexCode = $this->getRequest()->getParam('columnIndexCode');
        if ($customerId) {
            $customer = Mage::getModel('customer/customer')->load($customerId);
            switch ($columnIndexCode) {
                case 1:
                    $oldValue = $customer->getName();
                    $customer->setFirstname($firstName)
                            ->setLastname($lastName);
                    break;
                case 2:
                    $oldValue = $customer->getEmail();
                    $customer->setEmail($newValue);
                    break;
                case 3:
                    $oldValue = $customer->getTelephone();
                    $customer->setTelephone($newValue);
                    break;
                case 4:
                    $oldValue = $customer->getData("customer_satisfaction_type");
                    $customer->setData('customer_satisfaction_type', $newValue);
                    break;
            }
            try {
                $customer->save();
                $this->getResponse()->setBody($newValue);
                Mage::getSingleton('adminhtml/session')->addSuccess('Updated Successfully');
            } catch (Exception $e) {
                $this->getResponse()->setBody($oldValue);
                Mage::getSingleton('adminhtml/session')->addError('Updated Failed');
            }
        }
    }

    /**
     * Inline editting order warranty info
     */
    public function updateorderAction() {
        $orderId = (int) $this->getRequest()->getParam('order_id');
        $newValue = $this->getRequest()->getParam('value');
        $columnIndexCode = $this->getRequest()->getParam('columnIndexCode');

        if ($orderId) {
            $order = Mage::getModel('sales/order')->load($orderId);
            switch ($columnIndexCode) {
                case 1:
                    $oldValue = $order->getWarrantyDate();
                    $order->setWarrantyDate($newValue);
                    break;
                case 2:
                    $oldValue = $order->getWarrantyResult();
                    $order->setWarrantyResult($newValue);
                    break;
            }
            try {
                $order->save();
                $this->getResponse()->setBody($newValue);
                Mage::getSingleton('adminhtml/session')->addSuccess('Updated Successfully');
            } catch (Exception $e) {
                $this->getResponse()->setBody($oldValue);
                Mage::getSingleton('adminhtml/session')->addError('Updated Failed');
            }
        }
    }

    /**
     * export grid item to CSV type
     */
    public function exportCsvAction() {
        $fileName = 'allcustomers.csv';
        $content = $this->getLayout()
                ->createBlock('inventorycustomer/adminhtml_allcustomers_grid')
                ->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }

}
