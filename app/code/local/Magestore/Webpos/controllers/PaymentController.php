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
 * @package     Magestore_Webpos
 * @copyright   Copyright (c) 2012 Magestore (http://www.magestore.com/)
 * @license     http://www.magestore.com/license-agreement.html
 */

/**
 * Webpos Index Controller
 * 
 * @category    Magestore
 * @package     Magestore_Webpos
 * @author      Magestore Developer
 */
class Magestore_Webpos_PaymentController extends Magestore_Webpos_Controller_Action {

    public function getOnepage() {
        return Mage::getSingleton('checkout/type_onepage');
    }

    public function getSession() {
        return Mage::getSingleton('checkout/session');
    }

    public function saveDataAction() {
        if (!Mage::helper('magenotification')->checkLicenseKeyFrontController($this)) {
            return;
        }
		$helperPayment = Mage::helper('webpos/payment');
        $shipping_method = $this->getRequest()->getPost('shipping_method', 'webpos_shipping_free');
        $payment_method = $this->getRequest()->getPost('payment_method', 'cashforpos');
        if ((empty($shipping_method) || $shipping_method == '')&& $helperPayment->isWebposShippingEnabled())
            $shipping_method = 'webpos_shipping_free';
        if ((empty($payment_method) || $payment_method == '') && $helperPayment->isCashPaymentEnabled())
            $payment_method = 'cashforpos';
		
        try {
            $this->getOnepage()->saveShippingMethod($shipping_method);
        } catch (Exception $e) {
            $result['errorMessage'] = $e->getMessage();
        }
        try {
            $payment = $this->getRequest()->getPost('payment', array());
            $payment['method'] = $payment_method;
            Mage::helper('webpos')->savePaymentMethod($payment);
        } catch (Exception $e) {
            $result['errorMessage'] = $e->getMessage();
        }
		$this->getSession()->getQuote()->collectTotals()->save();
        $result['shipping_method'] = $this->getLayout()->createBlock('checkout/onepage_shipping_method_available')
                ->setTemplate('webpos/webpos/shipping_method.phtml')
                ->toHtml();
        $result['payment_method'] = $this->getLayout()->createBlock('webpos/onepage_payment_methods')
                ->setTemplate('webpos/webpos/payment_method.phtml')
                ->toHtml();
		// Changed By Tuan bun (27/08/2015): update item when save payment
        $result['totals'] = $this->getLayout()->createBlock('webpos/cart_totals')
            ->setTemplate('webpos/webpos/review/totals.phtml')
            ->toHtml();
        $result['pos_items'] = $this->getLayout()->createBlock('webpos/cart_items')
            ->setTemplate('webpos/webpos/cart/items.phtml')
            ->toHtml();
		$result['number_item'] = Mage::helper('checkout/cart')->getSummaryCount();
		// Changed By Tuan bun (27/08/2015): update item when save payment
        $grandTotal = Mage::getModel('checkout/session')->getQuote()->getGrandTotal();
        $result['grandTotals'] = Mage::app()->getStore()->formatPrice($grandTotal);
//        $downgrandtotal = ($grandTotal % 50 == 0) ? $grandTotal : floor($grandTotal - $grandTotal % 50);
//        $upgrandtotal = ($grandTotal % 50 == 0) ? $grandTotal : floor($grandTotal - $grandTotal % 50 + 50);
        $downgrandtotal = Mage::helper('webpos')->round_down_cashin($grandTotal);
        $upgrandtotal = Mage::helper('webpos')->round_up_cashin($grandTotal);
        $result['downgrandtotal'] = Mage::app()->getStore()->formatPrice($downgrandtotal, ".");
        $result['upgrandtotal'] = Mage::app()->getStore()->formatPrice($upgrandtotal, ".");

        $this->getResponse()->setBody(Zend_Json::encode($result));
    }
	
	public function checkNetworkAction(){
		die('success');
	}
}
