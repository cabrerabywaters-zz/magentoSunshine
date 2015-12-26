<?php

class Magestore_Webpos_Model_Payment_Method_Creditcard extends Mage_Payment_Model_Method_Abstract {
    /* This model define payment method */

    protected $_code = 'ccforpos';
    protected $_infoBlockType = 'webpos/payment_method_cc_info_cc';

    public function isAvailable($quote = null) {
		$routeName = Mage::app()->getRequest()->getRouteName();
		$ccenabled = Mage::helper('webpos/payment')->isCcPaymentEnabled();
        if ($routeName == "webpos" && $ccenabled == true )
            return true;
        else
            return false;
    }

}

?>
