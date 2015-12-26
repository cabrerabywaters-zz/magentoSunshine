<?php
/**
 * MageWorx
 * Multi Fees Extension
 *
 * @category   MageWorx
 * @package    MageWorx_MultiFees
 * @copyright  Copyright (c) 2015 MageWorx (http://www.mageworx.com/)
 */

class MageWorx_MultiFees_Model_Sales_Order_Creditmemo_Total extends Mage_Sales_Model_Order_Creditmemo_Total_Abstract
{
    /**
     * @param Mage_Sales_Model_Order_Creditmemo $creditmemo
     * @return $this|Mage_Sales_Model_Order_Creditmemo_Total_Abstract
     */
    public function collect(Mage_Sales_Model_Order_Creditmemo $creditmemo) {
        $order = $creditmemo->getOrder();
        if ($order->getMultifeesAmount() > 0 && $order->getMultifeesRefunded() < $order->getMultifeesInvoiced()) {
            $creditmemo->setMultifeesAmount($order->getMultifeesInvoiced() - $order->getMultifeesRefunded());
            $creditmemo->setBaseMultifeesAmount($order->getBaseMultifeesInvoiced() - $order->getBaseMultifeesRefunded());
            $creditmemo->setMultifeesTaxAmount($order->getMultifeesTaxAmount());
            $creditmemo->setBaseMultifeesTaxAmount($order->getBaseMultifeesTaxAmount());
            $creditmemo->setDetailsMultifees($order->getDetailsMultifees());            
            
            $creditmemo->setTaxAmount($creditmemo->getTaxAmount()+$creditmemo->getMultifeesTaxAmount());
            $creditmemo->setBaseTaxAmount($creditmemo->getBaseTaxAmount()+$creditmemo->getBaseMultifeesTaxAmount());
            $creditmemo->setGrandTotal($creditmemo->getGrandTotal() + $creditmemo->getMultifeesAmount());
            $creditmemo->setBaseGrandTotal($creditmemo->getBaseGrandTotal() + $creditmemo->getBaseMultifeesAmount());            
        } else {
            $creditmemo->setMultifeesAmount(0);
            $creditmemo->setBaseMultifeesAmount(0);
            $creditmemo->setMultifeesTaxAmount(0);
            $creditmemo->setBaseMultifeesTaxAmount(0);
            $creditmemo->setDetailsMultifees('');
        }
        return $this;
    }        
}
