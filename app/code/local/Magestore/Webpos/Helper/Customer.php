<?php
/**
 * Created by PhpStorm.
 * User: Quoc Viet
 * Date: 08/07/2015
 * Time: 1:10 CH
 */
class Magestore_Webpos_Helper_Customer extends Mage_Core_Helper_Abstract {
    public function getDefaultFirstName() {
        return Mage::getStoreConfig('webpos/guest_checkout/first_name');
    }
    public function getDefaultLastName() {
        return Mage::getStoreConfig('webpos/guest_checkout/last_name');
    }
    public function getDefaultStreet() {
        return Mage::getStoreConfig('webpos/guest_checkout/street');
    }
    public function getDefaultCountry() {
        return Mage::getStoreConfig('webpos/guest_checkout/country_id');
    }
    public function getDefaultState() {
        return Mage::getStoreConfig('webpos/guest_checkout/region_id');
    }
    public function getDefaultCity() {
        return Mage::getStoreConfig('webpos/guest_checkout/city');
    }
    public function getDefaultZip() {
        return Mage::getStoreConfig('webpos/guest_checkout/zip');
    }
    public function getDefaultTelephone() {
        return Mage::getStoreConfig('webpos/guest_checkout/telephone');
    }
    public function getDefaultEmail() {
        return Mage::getStoreConfig('webpos/guest_checkout/email');
    }
	
	public function getDefaultCustomerId() {
        return Mage::getStoreConfig('webpos/guest_checkout/customer_id');
    }
	
	public function getAllDefaultCustomerInfo(){
		$customerData = array();
		$customerData['customer_id']= 	Mage::helper('webpos/customer')->getDefaultCustomerId();
		$customerData['country_id']= 	Mage::helper('webpos/customer')->getDefaultCountry();
        $customerData['region_id'] =  	Mage::helper('webpos/customer')->getDefaultState();
        $customerData['postcode']  =   	Mage::helper('webpos/customer')->getDefaultZip();
        $customerData['street']    =   	Mage::helper('webpos/customer')->getDefaultStreet();
        $customerData['telephone'] = 	Mage::helper('webpos/customer')->getDefaultTelephone();
        $customerData['city']      =    Mage::helper('webpos/customer')->getDefaultCity();
        $customerData['firstname'] =   	Mage::helper('webpos/customer')->getDefaultFirstName();
        $customerData['lastname']  =   	Mage::helper('webpos/customer')->getDefaultLastName();
        $customerData['email']     = 	Mage::helper('webpos/customer')->getDefaultEmail();
		return $customerData;
	}
	
	public function getCustomerHtml(Mage_Customer_Model_Customer $customer){
		$html = "<li onclick=\"addCustomerToCart(".$customer->getId().")\" style='width:100%; float:left; cursor: pointer' class='email-customer col-lg-6 col-md-6'><span style='float:left;'>".$customer->getFirstname()." ".$customer->getLastname()."</span><span style='float:right'><a href='mailto:".$customer->getEmail()."'>".$customer->getEmail()."</a></span></li>";
		return $html;
	}
}