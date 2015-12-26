<?php
/**
 * MageWorx
 * Multi Fees Extension
 *
 * @category   MageWorx
 * @package    MageWorx_MultiFees
 * @copyright  Copyright (c) 2015 MageWorx (http://www.mageworx.com/)
 */

class MageWorx_MultiFees_Model_Sales_Pdf_Tax extends Mage_Tax_Model_Sales_Pdf_Tax
{
    /**
     * @return array
     */
    public function getFullTaxInfo() {
        $fontSize       = $this->getFontSize() ? $this->getFontSize() : 7;
        $rates    = Mage::getResourceModel('sales/order_tax_collection')->loadByOrder($this->getOrder())->toArray();
        $fullInfo = Mage::getSingleton('tax/calculation')->reproduceProcess($rates['items']);
        $tax_info = array();

        if ($fullInfo) {
            foreach ($fullInfo as $info) {
                if (isset($info['hidden']) && $info['hidden']) {
                    continue;
                }

                $_amount = $info['amount'];

                foreach ($info['rates'] as $rate) {
                    $percent = $rate['percent'] ? ' (' . $rate['percent']. '%)' : '';

                    $tax_info[] = array(
                        'amount'    => $this->getAmountPrefix() . $this->getOrder()->formatPriceTxt($_amount),
                        'label'     => Mage::helper('tax')->__($rate['title']) . $percent . ':',
                        'font_size' => $fontSize
                    );
                }
            }
        }
        $taxClassAmount = $tax_info;
        return $taxClassAmount;
    }
 
}