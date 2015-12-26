<?php
class Magestore_Webpos_Block_Customer extends Mage_Checkout_Block_Onepage_Abstract {
    public function getCountryHtmlSelect($type) {
        if($type == 'shipping'){
            $address = $this->getQuote()->getShippingAddress();
        }else{
            $address = $this->getQuote()->getBillingAddress();            
        }
        $countryId = $address->getCountryId();
        if(is_null($countryId)){
            $countryId = Mage::getStoreConfig('general/country/default');
        }
        $select = $this->getLayout()->createBlock('core/html_select')
                ->setName($type . '[country_id]')
                ->setId($type . ':country_id')
                ->setClass('billingdata')
                ->setTitle(Mage::helper('webpos')->__('Country'))
                ->setValue($countryId)
                ->setOptions($this->getCountryOptions())
                ->setExtraParams('fieldkey="country"');
        if($type == 'shipping'){
            $select->setClass('shippingdata');
        }

        return $select->getHtml();
    }
    public function getBillingAddress() {
        $address = Mage::getModel('sales/quote_address');
        if($this->getQuote()->getBillingAddress()->getCustomerId())
            $address = $this->getQuote()->getBillingAddress();
        return $address;
    }
    public function getShippingAddress() {
        return $this->getQuote()->getShippingAddress();
    }

    public function isCustomerLoggedIn() {
        return Mage::getSingleton('customer/session')->isLoggedIn();
    }

    public function getTitle() {
        if ($this->getBillingAddress()->getCustomerId()) {
            $title = Mage::helper('webpos')->__('Edit Customer');
        } else {
            $title = Mage::helper('webpos')->__('New Customer');
        }
        return $title;
    }
    public function getCustomer(){
        $customer = Mage::getModel('customer/customer');
        if ($this->getBillingAddress()->getCustomerId()) {
            $customer->load($this->getBillingAddress()->getCustomerId());
        }
        return $customer;
    }
    public function getSaveCustomerUrl(){
        if($this->getCustomer()->getId()){
            return Mage::getUrl('webpos/index/editCustomer', array('_secure'=>true));
        }else{
            return Mage::getUrl('webpos/index/createCustomer', array('_secure'=>true));            
        }
    }

}