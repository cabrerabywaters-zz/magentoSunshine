<?php
/**
 * MageWorx
 * Multi Fees Extension
 *
 * @category   MageWorx
 * @package    MageWorx_MultiFees
 * @copyright  Copyright (c) 2015 MageWorx (http://www.mageworx.com/)
 */
require_once('Mage/Checkout/controllers/CartController.php');
class MageWorx_MultiFees_AjaxController extends Mage_Checkout_CartController //Mage_Core_Controller_Front_Action
{
    public function submitAction() {
        $feesPost = $this->getRequest()->getPost('fee');
        $storeId = Mage::app()->getStore()->getId();
        Mage::helper('mageworx_multifees')->addFeesToCart($feesPost, $storeId, true, 1, 0);
                
        // copy from partn::indexAction()
        $cart = $this->_getCart();
        if ($cart->getQuote()->getItemsCount()) {
            $cart->init();
            $cart->save();

            if (!$this->_getQuote()->validateMinimumAmount()) {
                $warning = Mage::getStoreConfig('sales/minimum_order/description');
                $cart->getCheckoutSession()->addNotice($warning);
            }
        }

        foreach ($cart->getQuote()->getMessages() as $message) {
            if ($message) {
                $cart->getCheckoutSession()->addMessage($message);
            }
        }

        /**
         * if customer enteres shopping cart we should mark quote
         * as modified bc he can has checkout page in another window.
         */
        $this->_getSession()->setCartWasUpdated(true);
        // end copy from partn::indexAction()
        
        $this->getLayout()
                ->getUpdate()
                //->addHandle('checkout_cart_index')
                ->addHandle('checkout_fee_submit');
        $this->loadLayoutUpdates()->_initLayoutMessages('checkout/session');
        $this->generateLayoutXml()->generateLayoutBlocks();
        $this->renderLayout();        
    }
    
}
