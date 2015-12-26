<?php
/**
 * MageWorx
 * Multi Fees Extension
 *
 * @category   MageWorx
 * @package    MageWorx_MultiFees
 * @copyright  Copyright (c) 2015 MageWorx (http://www.mageworx.com/)
 */

class MageWorx_MultiFees_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getImagesThumbnailsSize() {
        return intval(Mage::getStoreConfig('mageworx_multifees/main/images_thumbnails_size'));
    }
    
    public function isEnableCartFees() {
        return Mage::getStoreConfigFlag('mageworx_multifees/main/enable_cart');
    }
    
    // 0 - Custom Position, 1 - Above Crosssell, 2 - Below Crosssell, 3 - Above Coupon, 4 - Below Coupon, 5 - Above Shipping, 6 - Below Shipping;
    public function getPositionInCart() {
        return Mage::getStoreConfig('mageworx_multifees/main/position_in_cart');
    }
    
    public function isIncludeFeeInShippingPrice() {
        return Mage::getStoreConfig('mageworx_multifees/main/include_fee_in_shipping_price');
    }
    
    public function isTaxСalculationIncludesTax() {
        return Mage::getStoreConfig('mageworx_multifees/main/tax_calculation_includes_tax');
    }
    
    public function getTaxInBlock() {
        return Mage::getStoreConfig('mageworx_multifees/main/display_tax_in_block');
    }
    
    public function getTaxInCart() {
        return Mage::getStoreConfig('mageworx_multifees/main/display_tax_in_cart');
    }
    
    public function getTaxInSales() {
        return Mage::getStoreConfig('mageworx_multifees/main/display_tax_in_sales');
    }

    public function isEnablePaymentFees() {
        return Mage::getStoreConfigFlag('mageworx_multifees/main/enable_payment');
    }
    
    public function isEnableShippingFees() {
        return Mage::getStoreConfigFlag('mageworx_multifees/main/enable_shipping');
    }
    
//    public function isAutoAddTotal() {
//        return Mage::getStoreConfig('mageworx_sales/multifees/autoadd_total');
//    }
    
    public function isIncludingTax($store = null) {
        return (Mage::getStoreConfig('mageworx_multifees/main/display_tax', $store)==Mage_Tax_Model_Config::DISPLAY_TYPE_INCLUDING_TAX);
    }

    /**
     * @return array
     */
    public function getTypeArray() {
        return array(
            1 => $this->__('Cart Fee'),
            2 => $this->__('Payment Fee'),
            3 => $this->__('Shipping Fee')            
        );
    }

    /**
     * @param bool $all
     * @param bool $onlyCheckout
     * @return array
     */
    public function getInputTypeArray($all = false, $onlyCheckout = false) {        
        return array(
            1 => $this->__('Drop-Down'),
            2 => $this->__('Radio Button'),
            3 => $this->__('Checkbox'),
            4 => $this->__('Hidden'),
            5 => $this->__('Notice')
        );
    }

    /**
     * @return array
     */
    public function getStatusArray() {
        return array(
            1 => $this->__('Active'),
            0 => Mage::helper('catalog')->__('Disabled'),
        );
    }

    /**
     * @return array
     */
    public function getNoYesArray() {
        return array(
            0 => Mage::helper('catalog')->__('No'),
            1 => Mage::helper('catalog')->__('Yes')
        );
    }

    /**
     * @return array
     */
    public function getYesNoArray() {
        return array(
            1 => Mage::helper('catalog')->__('Yes'),
            0 => Mage::helper('catalog')->__('No')
        );
    }

    /**
     * @return array
     */
    public function getTaxClassesArray() {
        $options = Mage::getSingleton('tax/class_source_product')->toOptionArray();
        $taxClassesArr = array();
        foreach ($options as $option) {            
            $taxClassesArr[$option['value']] = $option['label'];            
        }
        return $taxClassesArr;        
    }

    /**
     * @return array
     */
    public function getPriceTypeArray() {
        return array(
            'fixed' => Mage::helper('catalog')->__('Fixed'),
            'percent' => $this->__('Percent'),
        );
    }

    /**
     * @param $optionId
     * @return string
     */
    public function getOptionImgPath($optionId) {
        return Mage::getBaseDir('media') . DS . 'multifees' . DS . $optionId . DS;
    }

    /**
     * @param $path
     * @return array
     */
    public function getFiles($path) {
        return @glob($path . "*.*");
    }

    /**
     * @param $optionId
     * @param bool $isArr
     * @return array|string
     */
    public function getOptionImgHtml($optionId, $isArr = false) {
        //return '';
        $path = $this->getOptionImgPath($optionId);
        $file = $this->getFiles($path);
        if (!$file) return '';
        $filePath = $file[0];
        $fileName = str_replace($path, '', $filePath);        
        if (!$fileName) return '';
        
        $imagesThumbnailsSize = $this->getImagesThumbnailsSize();        
        $smallPath = $path . $imagesThumbnailsSize . 'x' . DS;        
        $smallFilePath = $smallPath . $fileName;        
        if (!file_exists($smallFilePath)) $this->makeSmallImageFile($filePath, $smallPath, $fileName);        
        
        $imgUrl = Mage::getBaseUrl('media') . 'multifees/'. $optionId . '/' . $imagesThumbnailsSize . 'x/' . $fileName;
        $bigImgUrl = Mage::getBaseUrl('media') . 'multifees/'. $optionId . '/' . $fileName;        
        
        $impOption = array(
            'big_img_url' => $bigImgUrl,
            'url' => $imgUrl,
            'id' => $optionId
        );
        
        if ($isArr) return $impOption;
        
        return Mage::app()->getLayout()
                    ->createBlock('core/template')
                    ->setTemplate('mageworx/multifees/option_image.phtml')
                    ->addData(array('img' => new Varien_Object($impOption)))
                    ->toHtml();
    }

    /**
     * @return mixed
     */
    public function getEmptyOptionImgHtml() {        
        $impOption = array(
            'big_img_url' => '',
            'url' => '',
            'id' => 0
        );        
        return Mage::app()->getLayout()
                    ->createBlock('core/template')
                    ->setTemplate('mageworx/multifees/option_image.phtml')
                    ->addData(array('img' => new Varien_Object($impOption)))
                    ->toHtml();
    }

    /**
     * @param $fileOrig
     * @param $smallPath
     * @param $newFileName
     */
    public function makeSmallImageFile($fileOrig, $smallPath, $newFileName) {        
        $image = new Varien_Image($fileOrig);            
        $origHeight = $image->getOriginalHeight();
        $origWidth = $image->getOriginalWidth();
            
        // settings
        $image->keepAspectRatio(true);
        $image->keepFrame(true);
        $image->keepTransparency(true);
        $image->constrainOnly(false);
        $image->backgroundColor(array(255, 255, 255));
        $image->quality(90);    
            
            
        $width = null;
        $height = null;
        if (Mage::app()->getStore()->isAdmin()) {
            if ($origHeight > $origWidth) {
                $height = $this->getImagesThumbnailsSize();
            } else {
                $width = $this->getImagesThumbnailsSize();
            }
        } else {
            $configWidth = $this->getImagesThumbnailsSize();
            $configHeight = $this->getImagesThumbnailsSize();
            
            if ($origHeight > $origWidth) {
                $height = $configHeight;
            } else {
                $width = $configWidth;
            }
        }

        
        $image->resize($width, $height);
        
        $image->constrainOnly(true);
        $image->keepAspectRatio(true);
        $image->keepFrame(false);
        //$image->display();
        $image->save($smallPath, $newFileName);
    }

    /**
     * @param $optionId
     */
    public function removeOptionFile($optionId) {
        $dir = $this->getOptionImgPath($optionId);
        $this->deleteFolder($dir);
    }

    /**
     * @param $dir
     */
    public function deleteFolder($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir . DS . $object) == "dir") {
                        $this->deleteFolder($dir . DS . $object);
                    } else {
                        unlink($dir . DS . $object);
                    }
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }

    /**
     * $addressId = 0 - default address
     * @param int $addressId
     * @return array|null
     */
    public function getQuoteDetailsMultifees($addressId = 0) {
        if (Mage::app()->getStore()->isAdmin()) {
            $session = Mage::getSingleton('adminhtml/session_quote');
        } else {
            $session = Mage::getSingleton('checkout/session');
        }
        $detailsMultifeesData = $session->getDetailsMultifees();
        if (is_null($detailsMultifeesData)) return null;
        $detailsMultifees = array();
        if (isset($detailsMultifeesData[0])) $detailsMultifees = $detailsMultifeesData[0]; // get fees from default address
        // add fees from current address
        if ($addressId>0 && isset($detailsMultifeesData[$addressId])) {
            foreach($detailsMultifeesData[$addressId] as $feeId => $feeData) {
                $detailsMultifees[$feeId] = $feeData;
            }
        }
        return $detailsMultifees;
    }

    /**
     * @param $details
     * @param int $addressId
     */
    public function setQuoteDetailsMultifees($details, $addressId = 0) {
        if (Mage::app()->getStore()->isAdmin()) {
            $session = Mage::getSingleton('adminhtml/session_quote');
        } else {
            $session = Mage::getSingleton('checkout/session');
        }
        $detailsMultifees = $session->getDetailsMultifees();
        if (!is_array($detailsMultifees)) $detailsMultifees = array();
        $detailsMultifees[$addressId] = $details;        
        $session->setDetailsMultifees($detailsMultifees);
    }

    /**
     * $type = 0-All,1-Cart Fee,2-Payment Fee,3-Shipping Fee
     * @param $feesPost
     * @param $storeId
     * @param bool $collect
     * @param int $type
     * @param int $addressId
     * @param int $hidden
     */
    public function addFeesToCart($feesPost, $storeId, $collect = true, $type = 1, $addressId = 0, $hidden = 0) {        
        $feesData = array();
        // remove fees from session by type
        if ($type) {
            $feesData = $this->getQuoteDetailsMultifees($addressId);
            if ($feesData) {
                foreach ($feesData as $feeId=>$data) {
                    if ($data['type']==$type && $data['is_hidden']==$hidden) unset($feesData[$feeId]);
                }
            }
        }
        
        if ($feesPost && is_array($feesPost)) {
            $filter = new Zend_Filter();
            $filter->addFilter(new Zend_Filter_StringTrim());
            $filter->addFilter(new Zend_Filter_StripTags());            
            foreach ($feesPost as $feeId => $data) {
                $feeModel = Mage::getSingleton('mageworx_multifees/fee')->load($feeId);
                if (!$feeModel || !$feeModel->getId() || ($type && $feeModel->getType()!=$type) || !isset($data['options']) || !is_array($data['options']) || count($data['options'])==0) continue;
                foreach ($data['options'] as $optionId) {
                    $optionId = intval($optionId);
                    if (!$optionId) continue;
                    $opValue = array();
                    $opValue['title'] = Mage::getResourceSingleton('mageworx_multifees/language_option')->getTitle($optionId, $storeId);
                    $option = Mage::getSingleton('mageworx_multifees/option')->load($optionId);
                    
                    if ($option->getPriceType()=='percent') {
                        $opValue['percent'] = $option->getPrice();
                    } else {
                        $opValue['base_price'] = $option->getPrice();
                    }                    
                    
                    $feesData[$feeId]['options'][$optionId] = $opValue;                    
                }
                if (isset($feesData[$feeId]['options'])) {
                    $feesData[$feeId]['title'] = Mage::getResourceSingleton('mageworx_multifees/language_fee')->getTitle($feeId, $storeId);
                    $feesData[$feeId]['date_title'] = $feeModel->getDateFieldTitle();
                    $feesData[$feeId]['date'] = (isset($data['date'])?$filter->filter($data['date']):'');
                    $feesData[$feeId]['message_title'] = $feeModel->getCustomerMessageTitle();
                    $feesData[$feeId]['message'] = (isset($data['message'])?Mage::helper('core/string')->truncate($filter->filter($data['message']), 1024):'');
                    $feesData[$feeId]['applied_totals'] = explode(',', $feeModel->getAppliedTotals());
                }
                if (isset($feesData[$feeId])) {
                    $feesData[$feeId]['type'] = $feeModel->getType();
                    $feesData[$feeId]['is_onetime'] = $feeModel->getIsOnetime();
                    $feesData[$feeId]['is_hidden'] = ($feeModel->getInputType()==4 || $feeModel->getInputType()==5 ? 1 : 0);                    
                    $feesData[$feeId]['tax_class_id'] = $feeModel->getTaxClassId();
                }
            }
        }
        
        //if (!$feesData) $feesData = null;
        $this->setQuoteDetailsMultifees($feesData, $addressId);
        if (Mage::app()->getStore()->isAdmin()) {
            $session = Mage::getSingleton('adminhtml/session_quote');
        } else {
            $session = Mage::getSingleton('checkout/session');
        }
        if ($collect) $session->getQuote()->setTotalsCollectedFlag(false)->collectTotals();
    }

    /**
     * get correct $address
     * $sales = $quote | $order
     * @param $sales
     * @return mixed
     */
    public function getSalesAddress($sales) {
        $address = $sales->getShippingAddress();
        if ($address->getSubtotal()==0) {
            $address = $sales->getBillingAddress();
        }
        return $address;
    }

    /**
     * get all multifees
     * $type = 0-all, 1-Cart Fee,2-Payment Fee,3-Shipping Fee
     * $hidden = 0 - all, 1 - only hidden, 2 - only no hidden, 3 - only hidden+notice
     * $required = 0 - all, 1 - only required
     * $isDefault = 0 - all, 1 - only is_default=1
     * $code = 'checkmo', 'ccsave' or ''
     * @param int $type
     * @param int $required
     * @param int $hidden
     * @param int $isDefault
     * @param string $code
     * @param null $quote
     * @param null $address
     * @return mixed
     */
    public function getMultifees($type = 1, $required = 0, $hidden = 0, $isDefault = 0, $code = '', $quote=null, $address=null) {

        if (is_null($quote)) {
            if (Mage::app()->getStore()->isAdmin()) {
                $quote = Mage::getSingleton('adminhtml/session_quote')->getQuote();
            } else {
                $quote = Mage::getSingleton('checkout/cart')->getQuote();           
            }
        }
        if (is_null($address)) $address = $this->getSalesAddress($quote);
        
        $fees = Mage::getResourceModel('mageworx_multifees/fee_collection')
            ->addLabels($quote->getStoreId())
            ->addStoreFilter($quote->getStoreId())
            ->addStatusFilter()
            ->addTypeFilter($type)
            ->addRequiredFilter($required)
            ->addHiddenFilter($hidden)
            ->addIsDefaultFilter($isDefault)
            ->addSortOrder()
            ->load();
        
        // get customerGroupId
        if (Mage::app()->getStore()->isAdmin()) {
            if (Mage::getSingleton('adminhtml/session_quote')) $customerGroupId = Mage::getSingleton('adminhtml/session_quote')->getCustomer()->getGroupId(); else $customerGroupId = 0;        
        } else {
            $customerGroupId = Mage::getSingleton('customer/session')->isLoggedIn() ? Mage::getSingleton('customer/session')->getCustomer()->getGroupId() : 0;            
        }
        
        foreach ($fees as $key=>$fee) {            
            // check Group
            if ($fee->getCustomerGroupIds() && !in_array($customerGroupId, $fee->getCustomerGroupIds())) {
                $fees->removeItemByKey($key);
                continue;
            }
            
            // if all fees - prepare $code
            if ($type==0) {
                if ($fee->isPaymentFee()) $code = $quote->getPayment()->getMethod();
                if ($fee->isShippingFee()) $code = $address->getShippingMethod()?$address->getShippingMethod():'';
            }
            // check Sales Methods
            if ($code && $fee->getSalesMethods() && ($fee->isPaymentFee() || $fee->isShippingFee())) {
                if (substr($code, 0, 22)=='matrixrate_matrixrate_') $code = 'matrixrate_matrixrate';
                $salesMethods = explode(',', $fee->getSalesMethods());
                if (!in_array($code, $salesMethods)) {
                    $fees->removeItemByKey($key);
                    continue;
                }
            }
            
            // check Rule
            $conditions = unserialize($fee->getConditionsSerialized());            
            if ($conditions) {
                $conditionModel = Mage::getModel($conditions['type'])->setPrefix('conditions')->loadArray($conditions);
                Mage::register('multifees_fee', $fee);
                $result = $conditionModel->validate($address);
                Mage::unregister('multifees_fee');
                if (!$result) {
                    $fees->removeItemByKey($key);
                    continue;
                }
            }
            
            // add store_id
            $fee->setStoreId($quote->getStoreId());
            
        }
        return $fees;
    }

    /**
     * @param $price
     * @param $quote
     * @param $taxClassId
     * @param null $address
     * @return int
     */
    public function getTaxPrice($price, $quote, $taxClassId, $address=null) {
        if (!$quote) return 0;
        
        // prepare tax calculator
        if (!$address) $address = $this->getSalesAddress($quote);
        
        $calc = Mage::getSingleton('tax/calculation');
        $store = $quote->getStore();
        $addressTaxRequest = $calc->getRateRequest(
            $address,
            $quote->getBillingAddress(),
            $quote->getCustomerTaxClassId(),
            $store
        );                
        $addressTaxRequest->setProductClassId($taxClassId);                
        $rate = $calc->getRate($addressTaxRequest);
        
        return $calc->calcTaxAmount($price, $rate, false, true);
    }

    /**
     * @param $price
     * @param $quote
     * @param $taxClassId
     * @param null $address
     * @return mixed
     */
    public function getPriceExcludeTax($price, $quote, $taxClassId, $address=null) {
        if (!$quote || !$taxClassId || !$price) return $price;
        
        // prepare tax calculator
        if (!$address) $address = $this->getSalesAddress($quote);
        
        $calc = Mage::getSingleton('tax/calculation');
        $store = $quote->getStore();
        $addressTaxRequest = $calc->getRateRequest(
            $address,
            $quote->getBillingAddress(),
            $quote->getCustomerTaxClassId(),
            $store
        );                
        $addressTaxRequest->setProductClassId($taxClassId);                
        $rate = $calc->getRate($addressTaxRequest);
        return $store->roundPrice($price / ((100 + $rate)/100));
    }

    /**
     * @param $option
     * @param $fee
     * @return float|int|mixed|string
     */
    public function getOptionFormatPrice($option, $fee) {        
        $price = $option->getPrice();
        $taxClassId = $fee->getTaxClassId();
        if (Mage::app()->getStore()->isAdmin()) {
            $quote = Mage::getSingleton('adminhtml/session_quote')->getQuote();
        } else {
            $quote = Mage::getSingleton('checkout/cart')->getQuote();           
        }
        $address = $this->getSalesAddress($quote);
        
        $percent = 0;
        if ($option->getPriceType()=='percent') {
            $percent = $price;
            
            $baseSubtotal = floatval($address->getBaseSubtotalWithDiscount());
            $baseShipping = floatval($address->getBaseShippingAmount()); // - $address->getBaseShippingTaxAmount()
            $baseTax = floatval($address->getBaseTaxAmount());
            
            $baseMultifeesLeft = 0;
            $appliedTotals = explode(',', $fee->getAppliedTotals());
            foreach ($appliedTotals as $field) {
                switch ($field) {
                    case 'subtotal':                            
                        $baseMultifeesLeft += $baseSubtotal;
                        break;
                    case 'shipping':
                        $baseMultifeesLeft += $baseShipping;
                        break;
                    case 'tax':
                        $baseMultifeesLeft += $baseTax;
                        break;                       
                }
            }
            if ($baseMultifeesLeft>0 && $percent>0) $price = ($baseMultifeesLeft * $percent) / 100; else $price = 0;
            $percent = number_format(floatval($percent), 2, null, '') . '%';
        }
                               
        if ($fee->getIsOnetime()==0) $price = $price * intval($fee->getFoundQty($address->getId()));
        
        $store = $quote->getStore();
        $price = $store->convertPrice($price); // base price - to store price
        
        // tax_calculation_includes_tax
        if ($this->isTaxСalculationIncludesTax()) {
            $priceInclTax = $price;
            $price = $this->getPriceExcludeTax($price, $quote, $fee->getTaxClassId(), $address);
        } else {
            $priceInclTax = $price + $this->getTaxPrice($price, $quote, $taxClassId, $address);
        }
        
        $taxInBlock = $this->getTaxInBlock();
        if ($taxInBlock==1) {
            $price = $store->formatPrice($price, false);
            if ($percent) $price = $percent . ' (' . $price . ')';
            return $price;
        } else if ($taxInBlock==2) {
            $priceInclTax = $store->formatPrice($priceInclTax, false);
            if ($percent) $priceInclTax = $percent . ' (' . $priceInclTax . ')';
            return $priceInclTax;
        } else if ($taxInBlock==3) {
            $price = $store->formatPrice($price, false);
            $priceInclTax = $store->formatPrice($priceInclTax, false);
            if ($percent) {
                return $percent . ' (' . $price . ', ' . $this->__('Incl. Tax %s', $priceInclTax) . ')';
            } else {
                return $price . ' (' . $this->__('Incl. Tax %s', $priceInclTax) . ')';
            }
        }
        
    }

    /**
     * @param $data
     * @param bool $isStripTags
     * @return array
     */
    public function getFilter($data, $isStripTags=true) {
        $result = array();
        $filter = new Zend_Filter();
        $filter->addFilter(new Zend_Filter_StringTrim());
        if ($isStripTags) $filter->addFilter(new Zend_Filter_StripTags());

        if ($data) {
            foreach ($data as $key => $value) {
                if (is_array($value)) {
                    $result[$key] = $this->getFilter($value, $isStripTags);
                } else {
                    $result[$key] = $filter->filter($value);
                }
            }
        }
        return $result;
    }        
}