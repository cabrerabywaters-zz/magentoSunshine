<?php
/**
 * MageWorx
 * Multi Fees Extension
 *
 * @category   MageWorx
 * @package    MageWorx_MultiFees
 * @copyright  Copyright (c) 2015 MageWorx (http://www.mageworx.com/)
 */

class MageWorx_MultiFees_Model_Sales_Quote_Total extends Mage_Sales_Model_Quote_Address_Total_Abstract
{

    protected $_collected = false;

    public function __construct() {
        $this->setCode('multifees');
    }

    

    /**
     * @param Mage_Sales_Model_Quote_Address $address
     * @return $this|Mage_Sales_Model_Quote_Address_Total_Abstract
     */
    public function collect(Mage_Sales_Model_Quote_Address $address) {
        $helper = Mage::helper('mageworx_multifees');

        if ($address->getSubtotal()==0 && floatval($address->getCustomerCreditAmount())==0) return $this;
        if ($this->_collected) return $this;


////////////////////////////////////////////////////////////////////
            $subtotalRowTOTAL = 0;
            $CompanyTotal =0;
            $PersonTotal = 0;
            $quote = Mage::getSingleton('checkout/cart')->getQuote();
            $cartItems = $quote->getAllVisibleItems();

            $userGroupId = Mage::getSingleton('customer/session')->getCustomerGroupId();
            
            
                foreach ($cartItems as $item) {
                    $subtotalRow = 0;

                    $_product = Mage::getModel('catalog/product')->load($item->getProductId());
                    $ids = $_product->getCategoryIds();
                   
                    $productId = $item->getProductId();
                    $qty = $item->getQty();
                    $price = $item->getProduct()->getPrice();
                    $subtotalRow = $subtotalRow + ($price * $qty);


                    //If the product has perception tax for persons
                     if(array_search("372",$ids) != false && $subtotalRow >=100)
                    {
                        $PersonTotal = $PersonTotal + $subtotalRow;
                    }

                    //If the product has perception tax for persons
                     if(array_search("373",$ids) != false)
                    {
                        $CompanyTotal = $CompanyTotal + $subtotalRow;
                    }

                }

                //If the user is Not log in
                if($userGroupId == 0 || $userGroupId == 8 )
                {
                    $subtotalRowTOTAL =$PersonTotal;
                    $subtotalRowTOTAL = $subtotalRowTOTAL/1.18;
                }
                elseif ($userGroupId == 8) {
                    $subtotalRowTOTAL =$CompanyTotal;
                    $subtotalRowTOTAL = $subtotalRowTOTAL/1.18;
                }
                else{
                    $subtotalRowTOTAL =0;
                }



            
//////////////////////////////////////////////////////////////////////////////////////////////////////
        
        $baseSubtotalRow = floatval($subtotalRowTOTAL);
        
        $baseSubtotal = floatval($address->getBaseSubtotalWithDiscount());

        $baseShipping = floatval($address->getBaseShippingAmount()); // - $address->getBaseShippingTaxAmount()
        $baseTax = floatval($address->getBaseTaxAmount());
        
        //amount
        $address->setMultifeesAmount(0);
        $address->setBaseMultifeesAmount(0);
        $address->setDetailsMultifees(null);
        
        $quote = $address->getQuote();

        $feeMessages = new Varien_Data_Collection();

        // add payment fee (front and admin)
        if (Mage::app()->getRequest()->getPost('is_payment_fee', false)) {
            $feesPost = Mage::app()->getRequest()->getPost('fee', array());
            foreach ($feesPost as $feeId => $data) {
                if (isset($data['message'])) {
                    $obj = new Varien_Object();
                    $obj->setFeeId($feeId);
                    $obj->setMessage($data['message']);
                    $feeMessages->addItem($obj);
                }
            }
            $helper->addFeesToCart($feesPost, $quote->getStoreId(), false, 2, 0);
        }
        // add shipping fee (front and admin)
        if (Mage::app()->getRequest()->getPost('is_shipping_fee', false)) {
            $feesPost = Mage::app()->getRequest()->getPost('fee', array());
            foreach ($feesPost as $feeId => $data) {
                if (isset($data['message'])) {
                    $obj = new Varien_Object();
                    $obj->setFeeId($feeId);
                    $obj->setMessage($data['message']);
                    $feeMessages->addItem($obj);
                }
            }
            $helper->addFeesToCart($feesPost, $quote->getStoreId(), false, 3, 0);
        }
        
        $feesData = $helper->getQuoteDetailsMultifees($address->getId());
        
        // autoadd default cart fees, no hidden
        if (is_null($feesData) && $helper->isEnableCartFees()) $this->autoAddFeesByParams(1, 0, 2, 1, '', $quote, $address, $helper, null);
        // autoadd hidden cart fees
        if ($helper->isEnableCartFees()) $this->autoAddFeesByParams(1, 0, 1, 1, '', $quote, $address, $helper, null);
        // autoadd hidden shipping fees
        if ($helper->isEnableShippingFees() && $address->getShippingMethod()) $this->autoAddFeesByParams(3, 0, 1, 1, strval($address->getShippingMethod()), $quote, $address, $helper, $feeMessages);
        // autoadd hidden fees
        if ($helper->isEnablePaymentFees() && $quote->getPayment()->getMethod()) {
            // autoadd default payment fees, no hidden
            if (is_null($feesData) && Mage::app()->getRequest()->getControllerName()=='express') $this->autoAddFeesByParams(2, 0, 3, 1, $quote->getPayment()->getMethod(), $quote, $address, $helper,null);
            // autoadd hidden payment fees
            $this->autoAddFeesByParams(2, 0, 1, 1, $quote->getPayment()->getMethod(), $quote, $address, $helper, $feeMessages);
        }

        $feesData = $helper->getQuoteDetailsMultifees($address->getId());        
        
        if (!is_array($feesData) || count($feesData)==0) return $this;
                
        
        // check conditions added fees
        
        // get all possible fees
        $possibleFeesCollection = $helper->getMultifees(0, 0, 0, 0, '', $quote, $address);
        $possibleFees = array();
        foreach($possibleFeesCollection as $fee) {
            $possibleFees[$fee->getId()] = $fee;
        }
        
        $store = $quote->getStore();        
        
        $baseMultifeesAmount = 0;
        $baseMultifeesTaxAmount = 0;
        foreach ($feesData as $feeId => $data) {
            if (!isset($data['options']) || !isset($possibleFees[$feeId])) {
                unset($feesData[$feeId]);
                continue;
            }
            $baseMultifeesLeft = 0;

            $appliedTotals = $data['applied_totals'];
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
                    case 'rowsubtotal':
                        $baseMultifeesLeft += $baseSubtotalRow;
                    break;                      
                }
            }



            $taxClassId = $data['tax_class_id'];
            // Caluclation the subtotal/discount with/without tax
            $baseSubtotal = floatval($address->getBaseSubtotal());
            $discountAmount = $address->getBaseDiscountAmount();
            if (Mage::helper('tax')->discountTax()) { // check discount with tax
                $discountAmount = floatval($helper->getPriceExcludeTax($discountAmount,$quote, $data['tax_class_id']));
            }

            $baseSubtotal = floatval($baseSubtotal + $discountAmount);
            /////////////////////
            //Custom
            //////////////////////
            $baseSubtotalRow = floatval($baseSubtotalRow + $discountAmount);

            $feePrice = 0;
            $feeTax = 0;
            foreach ($data['options'] as $optionId=>$value) {
                if (isset($value['percent'])) {
                    $opBasePrice = ($baseMultifeesLeft * $value['percent']) / 100;
                } else {                    
                    $opBasePrice = $value['base_price'] * $possibleFees[$feeId]->getFoundQty($address->getId());
                }
                $opPrice = $store->convertPrice($opBasePrice);
                
                if ($helper->isTaxСalculationIncludesTax()) {
                    $opBaseTax = $opBasePrice - $helper->getPriceExcludeTax($opBasePrice, $quote, $taxClassId, $address);
                    $opTax = $opPrice - $helper->getPriceExcludeTax($opPrice, $quote, $taxClassId, $address);
                } else {
                    // add tax 
                    $opBasePrice += $opBaseTax = $helper->getTaxPrice($opBasePrice, $quote, $taxClassId, $address);                    
                    $opPrice += $opTax = $helper->getTaxPrice($opPrice, $quote, $taxClassId, $address);
                }
                
                // round price
                $opBasePrice = $store->roundPrice($opBasePrice);
                $opPrice = $store->roundPrice($opPrice);
                $opBaseTax = $store->roundPrice($opBaseTax);
                $opTax = $store->roundPrice($opTax);
                
                //$opPrice, $opBasePrice = inclTax
                
                $feesData[$feeId]['options'][$optionId]['base_price'] = $opBasePrice;
                $feesData[$feeId]['options'][$optionId]['price'] = $opPrice;
                $feesData[$feeId]['options'][$optionId]['base_tax'] = $opBaseTax;
                $feesData[$feeId]['options'][$optionId]['tax'] = $opTax;

                $feeTax += $opBaseTax;
                $feePrice += $opBasePrice;
            }                                

            $feesData[$feeId]['base_price'] = $feePrice;
            $feesData[$feeId]['price'] = $store->convertPrice($feePrice);
            $feesData[$feeId]['base_tax'] = $feeTax;
            $feesData[$feeId]['tax'] = $store->convertPrice($feeTax);

            $baseMultifeesAmount += $feePrice;
            $baseMultifeesTaxAmount += $feeTax;

        }
        
        $multifeesAmount = $store->roundPrice($store->convertPrice($baseMultifeesAmount));
        $baseMultifeesAmount = $store->roundPrice($baseMultifeesAmount);
        
        $multifeesTaxAmount = $store->roundPrice($store->convertPrice($baseMultifeesTaxAmount));
        $baseMultifeesTaxAmount = $store->roundPrice($baseMultifeesTaxAmount);
        
        
        if ($helper->isIncludeFeeInShippingPrice()) {
            $address->setBaseShippingAmount($baseMultifeesAmount - $baseMultifeesTaxAmount + $address->getBaseShippingAmount());
            $address->setShippingAmount($multifeesAmount - $multifeesTaxAmount + $address->getShippingAmount());
            
            $address->setBaseShippingTaxAmount($baseMultifeesTaxAmount + $address->getBaseShippingTaxAmount());
            $address->setShippingTaxAmount($multifeesTaxAmount + $address->getShippingTaxAmount());
            
            $address->setBaseShippingInclTax($baseMultifeesAmount + $address->getBaseShippingInclTax());
            $address->setShippingInclTax($multifeesAmount + $address->getShippingInclTax());
            
            $address->setBaseGrandTotal($address->getBaseGrandTotal() + $baseMultifeesAmount - $baseMultifeesTaxAmount);
            $address->setGrandTotal($address->getGrandTotal() + $multifeesAmount - $multifeesTaxAmount);
            
        } else {
            $address->setBaseMultifeesAmount($baseMultifeesAmount);
            $address->setMultifeesAmount($multifeesAmount);

            $address->setBaseMultifeesTaxAmount($baseMultifeesTaxAmount);
            $address->setMultifeesTaxAmount($multifeesTaxAmount);            

            $address->setDetailsMultifees(serialize($feesData));            

            $address->setBaseTotalAmount('multifees', $baseMultifeesAmount);
            $address->setTotalAmount('multifees', $multifeesAmount);
        }
        
        $address->setBaseTaxAmount($address->getBaseTaxAmount() + $baseMultifeesTaxAmount);
        $address->setTaxAmount($address->getTaxAmount() + $multifeesTaxAmount);
        
        // emulation $this->_saveAppliedTaxes($address, $applied, $tax, $baseTax, $rate); 
        $appliedTaxes = $address->getAppliedTaxes();
        if (is_array($appliedTaxes)) {
            foreach ($appliedTaxes as $row) {
                if (isset($appliedTaxes[$row['id']]['amount'])) {
                    $appliedTaxes[$row['id']]['amount']       += $multifeesTaxAmount;
                    $appliedTaxes[$row['id']]['base_amount']  += $baseMultifeesTaxAmount;
                    break;
                }
            }
            $address->setAppliedTaxes($appliedTaxes);
        }
        
        $this->_collected = true;
        return $this;
    }

    /**
     * $hidden = 0 - all, 1 - only hidden+notice, 2 - only no hidden
     * @param int $type
     * @param int $required
     * @param int $hidden
     * @param int $isDefault
     * @param string $code
     * @param null $quote
     * @param null $address
     * @param $helper
     * @param $feeMessages
     */
    public function autoAddFeesByParams($type = 1, $required = 0, $hidden = 0, $isDefault = 0, $code = '', $quote=null, $address=null, $helper, $feeMessages) {
        $fees = $helper->getMultiFees($type, $required, $hidden==1?3:0, $isDefault, $code, $quote, $address);
        if ($fees) {
            $feesPost = array();
            foreach($fees as $fee) {
                $feeOptions = $fee->getOptions();
                if ($feeOptions) {
                    foreach ($feeOptions as $option) {
                        if ($option->getIsDefault()) {
                            $feesPost[$fee->getFeeId()]['options'][] = $option->getId();
                            if ($feeMessages) {
                                foreach ($feeMessages as $feeMessage) {
                                    if ($fee->getFeeId() == $feeMessage->getFeeId()) {
                                        $feesPost[$fee->getFeeId()]['message'] = $feeMessage->getMessage();
                                    }
                                }
                            }
                        }
                    }
                }
            }
            if ($feesPost) $helper->addFeesToCart($feesPost, $quote->getStoreId(), false, $type, 0, $hidden==1?1:0);
        }
    }

    /**
     * @param Mage_Sales_Model_Quote_Address $address
     * @return $this|array
     */
    public function fetch(Mage_Sales_Model_Quote_Address $address) {
        if (!$this->_collected) $this->collect($address);
        if ($address->getMultifeesAmount()==0) return $this;
        if ($address->getSubtotal()==0 && floatval($address->getCustomerCreditAmount())==0) return $this;
        
        $helper = Mage::helper('mageworx_multifees');
        if ($address->getDetailsMultifees()) {
            $taxMode = $helper->getTaxInCart();
            // if $taxMode==1,3 ---> show Price Excl. Tax
            $address->addTotal(array(
                'code' => $this->getCode(),
                'title' => ($taxMode==3) ? $helper->__('Additional Fees (Excl. Tax)') : $helper->__('Additional Fees'),
                'value' =>  ($taxMode==1|| $taxMode==3) ? $address->getMultifeesAmount() - $address->getMultifeesTaxAmount(): $address->getMultifeesAmount(),
                'full_info' => $address->getDetailsMultifees(),
            ));
        }
        return $this;
    }

}