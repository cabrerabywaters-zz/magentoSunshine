<?php
/**
 * MageWorx
 * Multi Fees Extension
 *
 * @category   MageWorx
 * @package    MageWorx_MultiFees
 * @copyright  Copyright (c) 2015 MageWorx (http://www.mageworx.com/)
 */

class MageWorx_MultiFees_Model_Sales_Pdf_Total extends Mage_Sales_Model_Order_Pdf_Total_Default
{
    /**
     * @return array
     */
    public function getTotalsForDisplay() {        
        $source = $this->getSource();                
        $taxInSales = Mage::helper('mageworx_multifees')->getTaxInSales();
        
        $viewMode = array();
        if ($taxInSales==1) {
            $viewMode[] = false;
        } elseif ($taxInSales==2) {
            $viewMode[] = true;
        } elseif ($taxInSales==3) {
            $viewMode[] = false;
            $viewMode[] = true;
        }
        
        $totals = array();
        $fontSize = $this->getFontSize() ? $this->getFontSize() : 7;
        
        foreach ($viewMode as $inclTax) {                        
            $amount = ($inclTax?$source->getMultifeesAmount():$source->getMultifeesAmount()-$source->getMultifeesTaxAmount());
            if ($amount>0) {
                $amount = $this->getOrder()->formatPriceTxt($amount);

                if ($taxInSales!=3) {
                    $label = Mage::helper('mageworx_multifees')->__('Additional Fees');
                } else {
                    if ($inclTax) $label = Mage::helper('mageworx_multifees')->__('Additional Fees (Incl. Tax)'); else $label = Mage::helper('mageworx_multifees')->__('Additional Fees (Excl. Tax)');
                }            

                $totals[] = array (
                        'amount'    => $this->getAmountPrefix().$amount,
                        'label'     => $label . ':',
                        'font_size' => $fontSize
                    );
            }
        }
        
        return $totals;
    }
}