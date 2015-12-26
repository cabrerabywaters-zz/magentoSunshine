<?php
/**
 * MageWorx
 * Multi Fees Extension
 *
 * @category   MageWorx
 * @package    MageWorx_MultiFees
 * @copyright  Copyright (c) 2015 MageWorx (http://www.mageworx.com/)
 */

class MageWorx_MultiFees_Block_Sales_Order_Totals extends Mage_Core_Block_Abstract
{
    /**
     * @return $this
     */
    public function initTotals() {
        
        $source = $this->getParentBlock()->getSource();
        $multifeesAmount = $source->getMultifeesAmount();
        if ($multifeesAmount==0) return $this;                
        $multifeesTaxAmount = $source->getMultifeesTaxAmount();               
        
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
        
        foreach ($viewMode as $inclTax) {                        
            if ($taxInSales!=3) {
                $label = $this->__('Additional Fees');
            } else {
                if ($inclTax) $label = $this->__('Additional Fees (Incl. Tax)'); else $label = $this->__('Additional Fees (Excl. Tax)');
            }
            
            $multifeesTotal = new Varien_Object(array(
                'code'      => 'multifees' . ($inclTax?'_incl_tax':'') . '_amount',
                'field'  => 'multifees_amount',
                'label'  => $label,
                'value'  => $inclTax?$multifeesAmount:$multifeesAmount-$multifeesTaxAmount,
            ));
            $this->getParentBlock()->addTotalBefore($multifeesTotal, 'grand_total');
        }
        return $this;
    }
    
}
