<?php
class Ip_Redirection_Model_Observer_Customer extends Varien_Event_Observer
{
	/*method for Login Redirection*/
   public function customerLogin(Varien_Event_Observer $observer)
   {    
   		if (Mage::helper('redirection')->isEnabled()){	
   			$lasturl = Mage::getSingleton('core/session')->getLastUrl();
	     	if (strpos(Mage::helper('core/http')->getHttpReferer(), 'checkout') === false){
		     	if (! preg_match("#customer/account/create#", $lasturl) && Mage::helper('redirection')->isoptionEnabled('login_redirection')) {
				  		if($this->_CustomerGroup()) {
				   		$_session = $this->_getSession();
				   		$_session->setBeforeAuthUrl(Mage::helper('redirection')->setRedirectOnLogin());
			 			}
				}
			}
     	}
   }
   
   /*method for SignUp Redirection*/
   public function customerRegistration(Varien_Event_Observer $observer)
   {
   	if (Mage::helper('redirection')->isEnabled() && Mage::helper('redirection')->isoptionEnabled('registration_redirection')) {
   			$_session = $this->_getSession();
	   		$_session->setBeforeAuthUrl(Mage::helper('redirection')->setRedirectOnSignup());
   	}
   }
   
   /*method for Logout Redirection*/
   public function customerLogout(Varien_Event_Observer $observer)
   {
   	if (Mage::helper('redirection')->isEnabled() && Mage::helper('redirection')->isoptionEnabled('logout_redirection')) {
   		if($this->_CustomerGroup()) {
	   		$observer->getControllerAction()
	   		->setRedirectWithCookieCheck(Mage::helper('redirection')->setRedirectOnLogout());
   		}
   	}
   }
   
   /*check the customer group*/
   protected function _CustomerGroup()
   {
   	$customer = $this->_getSession()->getCustomer();
   	$group_id = Mage::helper('redirection')->getConfigValue('group');
   	if($customer) {
   		if($customer->getGroupId() == $group_id) {
   			return TRUE;
   		}
   	}

   	/*redirect for all General/Retailer and Wholeseller*/
	if($group_id == ''){
		return true;	
	}	
   }
   
   protected function _getSession()
   {
   	return Mage::getSingleton('customer/session');
   }
   
   
   
   
}