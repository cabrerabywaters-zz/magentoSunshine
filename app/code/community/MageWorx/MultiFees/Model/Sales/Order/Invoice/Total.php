<?php
/**
 * MageWorx
 * Multi Fees Extension
 *
 * @category   MageWorx
 * @package    MageWorx_MultiFees
 * @copyright  Copyright (c) 2015 MageWorx (http://www.mageworx.com/)
 */

class MageWorx_MultiFees_Model_Sales_Order_Invoice_Total extends Mage_Sales_Model_Order_Invoice_Total_Abstract
{
    /**
     * @param Mage_Sales_Model_Order_Invoice $invoice
     * @return $this|Mage_Sales_Model_Order_Invoice_Total_Abstract
     */
    public function collect(Mage_Sales_Model_Order_Invoice $invoice) {   
        $order = $invoice->getOrder();
        if ($order->getMultifeesAmount() > 0 && $order->getMultifeesInvoiced() < ($order->getMultifeesAmount() - $order->getMultifeesCanceled())) {            
            $invoice->setMultifeesAmount($order->getMultifeesAmount() - $order->getMultifeesInvoiced() - $order->getMultifeesCanceled());
            $invoice->setBaseMultifeesAmount($order->getBaseMultifeesAmount()-$order->getBaseMultifeesInvoiced() - $order->getBaseMultifeesCanceled());            
            $invoice->setMultifeesTaxAmount($order->getMultifeesTaxAmount());
            $invoice->setBaseMultifeesTaxAmount($order->getBaseMultifeesTaxAmount());
            $invoice->setDetailsMultifees($order->getDetailsMultifees());            
                        
            $invoice->setGrandTotal($invoice->getGrandTotal() + $invoice->getMultifeesAmount() - $invoice->getMultifeesTaxAmount());
            $invoice->setBaseGrandTotal($invoice->getBaseGrandTotal() + $invoice->getBaseMultifeesAmount()- $invoice->getBaseMultifeesTaxAmount());
        } else {
            $invoice->setMultifeesAmount(0);
            $invoice->setBaseMultifeesAmount(0);
            $invoice->setMultifeesTaxAmount(0);
            $invoice->setBaseMultifeesTaxAmount(0);
            $invoice->setDetailsMultifees('');
        }
        return $this;
    }
}
