<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Info
 *
 * @author Ea Design
 */
class EaDesign_PdfGenerator_Model_Entity_Additional_Info extends EaDesign_PdfGenerator_Model_Entity_Pdfgenerator
{

    public function getStoreId()
    {
        return $this->getOrder()->getStoreId();
    }

    public function getTheInfoVariables()
    {
        $order = $this->getOrder();
        $store = Mage::app()->getStore($this->getStoreId());
        $image = Mage::getStoreConfig('sales/identity/logo', $this->getStoreId());
        $sourceDate = Mage::helper('core')->formatDate($this->getSource()->getCreatedAt(), 'medium', false);
        $variables = array(
            'ea_logo_store' => array(
                'value' => '<img src="' . Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . '/sales/store/logo/' . $image . '" />',
            ),
            'ea_order_number' => array(
                'value' => $this->getOrder()->getRealOrderId(),
                'label' => Mage::helper('sales')->__('Order # %s')
            ),
            'ea_purcase_from_website' => array(
                'value' => $store->getWebsite()->getName(),
                'label' => Mage::helper('sales')->__('Purchased From')
            ),
            'ea_order_group' => array(
                'value' => $store->getGroup()->getName(),
                'label' => Mage::helper('pdfgenerator')->__('Purchased From Store')
            ),
            'ea_order_store' => array(
                'value' => $store->getName(),
                'label' => Mage::helper('sales')->__('Purchased From Website')
            ),
            'ea_order_status' => array(
                'value' => $this->getOrder()->getStatus(),
                'label' => Mage::helper('sales')->__('Order Status')
            ),
            'ea_source_date' => array(
                'value' => $sourceDate,
                'label' => Mage::helper('sales')->__('Order Date')
            ),
            'ea_order_totalpaid' => array(
                'value' => $order->formatPriceTxt($this->getOrder()->getTotalPaid()),
                'label' => Mage::helper('sales')->__('Total Paid')
            ),
            'ea_order_totalrefunded' => array(
                'value' => $order->formatPriceTxt($this->getOrder()->getTotalRefunded()),
                'label' => Mage::helper('sales')->__('Total Refunded')
            ),
            'ea_order_totaldue' => array(
                'value' => $order->formatPriceTxt($this->getOrder()->getTotalDue()),
                'label' => Mage::helper('sales')->__('Total Due')
            ),
        );

        return $variables;
    }

    public function getTheInvoiceVariables()
    {
        $invoice = $this->getSource();


        $comments = $invoice->getCommentsCollection()->getItems();
        if (count($comments)) {
            foreach ($comments as $comment) {
                $commentArr[] = $comment->getData('comment');
            }
            $commentData = implode('<br><br>', $commentArr);
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //All these has being added after, just some quickway to retrive custom Invoice Variables
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $percepcion ="";
        $igv = "";
        $grand_total = "";
        $InvoiceID = $invoice->getIncrementId();
        $read = Mage::getSingleton('core/resource')->getConnection('core_read') ;
        $result =  $read->fetchAll("SELECT SOT.amount FROM sales_flat_invoice  as SFI, sales_order_tax as SOT
                                    WHERE SFI.increment_id = $InvoiceID and SFI.order_id = SOT.order_id and SOT.code = 'PE-PERCEPCION-2%'");
        $percepcion = $result[0]["amount"];
        $result =  $read->fetchAll("SELECT SOT.amount FROM sales_flat_invoice  as SFI, sales_order_tax as SOT
                                    WHERE SFI.increment_id = $InvoiceID and SFI.order_id = SOT.order_id and SOT.code = 'PE-IGV-18%'");
        $igv = $result[0]["amount"];
        $igv = round($igv);
        $igv  = number_format($igv , 0, '', '.');
        $result =  $read->fetchAll("SELECT base_subtotal FROM sales_flat_invoice 
                                WHERE increment_id = $InvoiceID");
        $base_sub_total = $result[0]["base_subtotal"];
        $subtotal_Plus_IGV = $base_sub_total + $igv;


        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $variables = array(
            'ea_invoice_id' => array(
                'value' => $invoice->getIncrementId(),
                'label' => Mage::helper('pdfgenerator')->__('Invoice Id'),
            ),
            'ea_invoice_status' => array(
                'value' => $invoice->getStateName(),
                'label' => Mage::helper('pdfgenerator')->__('Invoice Status'),
            ),
            'ea_invoice_date' => array(
                'value' => Mage::helper('core')->formatDate($invoice->getCreatedAtDate(), 'medium', false),
                'label' => Mage::helper('pdfgenerator')->__('Invoice Date'),
            ),
            'ea_invoice_comments' => array(
                'value' => $commentData,
                'label' => Mage::helper('pdfgenerator')->__('Comments'),
            ),
            'custom_invoice_perception' => array(
                'value' => $percepcion,
                'label' => Mage::helper('pdfgenerator')->__('PE-Percepcion'),
            ),
              'custom_invoice_igv' => array(
                'value' => $igv,
                'label' => Mage::helper('pdfgenerator')->__('PE-IGV'),
            ),
               'subtotal_Plus_IGV' => array(
                'value' => $subtotal_Plus_IGV,
                'label' => Mage::helper('pdfgenerator')->__('PE-Subtotal-Plus-IGV'),
            ),
        );


        return $variables;
    }

    public function getTheCustomerVariables()
    {

        $order = $this->getSource()->getOrder();


        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //All these has being added after, just some quickway to retrive custom values for the customer
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
         $customer = $order->getData('customer_id');
          $giro = "";
          $nombre = "";
          $ciudad = "";
          $comuna = "";
          $telefono = "";
          $direccion = "";
          $discount = "";
          $discount =  $order->getData('affiliateplus_discount');
          $discount_peru = round($discount);
          $discount_peru  = number_format($discount_peru , 0, '', '.');
          $discount_peru = "S/. ".$discount_peru;
          $discount = ceil($discount/1.19);
          
          $discount  = number_format($discount , 0, '', '.');
          $discount = "$".$discount;

 

          
              $read = Mage::getSingleton('core/resource')->getConnection('core_read') ;
             
              $result =  $read->fetchAll("Select value from customer_entity_varchar where attribute_id = 167 and entity_id = $customer");
              $giro = $result[0]["value"];
               $result =  $read->fetchAll("Select value from customer_entity_varchar where attribute_id = 169 and entity_id = $customer");
              $nombre= $result[0]["value"];
               $result =  $read->fetchAll("Select value from customer_entity_varchar where attribute_id = 170 and entity_id = $customer");
              $ciudad = $result[0]["value"];
               $result =  $read->fetchAll("Select value from customer_entity_varchar where attribute_id = 171 and entity_id = $customer");
              $comuna = $result[0]["value"];
               $result =  $read->fetchAll("Select value from customer_entity_varchar where attribute_id = 172 and entity_id = $customer");
              $telefono= $result[0]["value"];
                $result =  $read->fetchAll("Select value from customer_entity_varchar where attribute_id = 168 and entity_id = $customer");
              $direccion= $result[0]["value"];
             
          
            
           ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

         
 
       



        $variables = array(
            'customer_name' => array(
                'value' => $order->getData('customer_lastname') . ' ' . $order->getData('customer_firstname'),
                'label' => Mage::helper('sales')->__('Customer Name'),
            ),
            'customer_email' => array(
                'value' => $order->getCustomerEmail(),
                'label' => Mage::helper('sales')->__('Email'),
            ),
            'customer_group' => array(
                'value' => $order->getData('customer_group_id'),
                'label' => Mage::helper('sales')->__('Customer Group'),
            ),
            'customer_firstname' => array(
                'value' => $order->getData('customer_firstname'),
                'label' => Mage::helper('customer')->__('First Name'),
            ),
            'customer_lastname' => array(
                'value' => $order->getData('customer_lastname'),
                'label' => Mage::helper('customer')->__('Last Name'),
            ),
            'customer_middlename' => array(
                'value' => $order->getData('customer_middlename'),
                'label' => Mage::helper('customer')->__('Middle Name/Initial'),
            ),
            'customer_prefix' => array(
                'value' => $order->getData('customer_prefix'),
                'label' => Mage::helper('customer')->__('Prefix'),
            ),
            'customer_suffix' => array(
                'value' => $order->getData('customer_suffix'),
                'label' => Mage::helper('customer')->__('Suffix'),
            ),
            'customer_taxvat' => array(
                'value' => $order->getData('customer_taxvat'),
                'label' => Mage::helper('customer')->__('Tax/VAT number'),
            ),

            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //All these has being added after, just some quickway to retrive custom values for the customer
            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

             'customer_giro' => array(
                'value' => $giro,
                'label' => Mage::helper('customer')->__('Giro'),
            ),
             'customer_fact_name' => array(
                'value' => $nombre,
                'label' => Mage::helper('customer')->__('Nombre Facturacion'),
            ),
             'customer_fact_city' => array(
                'value' => $ciudad,
                'label' => Mage::helper('customer')->__('Ciudad Facturacion'),
            ),
             'customer_fact_comuna' => array(
                'value' => $comuna,
                'label' => Mage::helper('customer')->__('Comuna Facturacion'),
            ),
             'customer_fact_phone' => array(
                'value' => $telefono,
                'label' => Mage::helper('customer')->__('Telefono Facturacion'),
            ),
              'customer_fact_address' => array(
                'value' => $direccion,
                'label' => Mage::helper('customer')->__('Direccion Comercial'),
            ),
               'affiliatePlus_discount' => array(
                'value' => $discount,
                'label' => Mage::helper('customer')->__('Affiliate Discount'),
            ),
               'affiliatePlus_discount_peru' => array(
                'value' => $discount_peru,
                'label' => Mage::helper('customer')->__('Affiliate Discount Peru'),
            ),
            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            'customer_dob' => array(
                'value' => Mage::helper('core')->formatDate($order->getData('customer_dob'), 'medium', false),
                'label' => Mage::helper('customer')->__('Date Of Birth'),
            ),
        );

        return $variables;
    }

    public function getTheAddresInfo()
    {
        $order = $this->getOrder();
        $billingInfo = $order->getBillingAddress()->getFormated(true);
        if ($order->getShippingAddress()) {
            $shippingInfo = $order->getShippingAddress()->getFormated(true);
        } else {
            $shippingInfo = '';
        }
        $variables = array(
            'billing_address' => array(
                'value' => $billingInfo,
                'label' => Mage::helper('sales')->__('Billing Address'),
            ),
            'shipping_address' => array(
                'value' => $shippingInfo,
                'label' => Mage::helper('sales')->__('Shipping Address'),
            )
        );
        return $variables;
    }

    public function getThePaymentInfo()
    {
        $order = $this->getOrder();
        $paymentInfo = $order->getPayment()->getMethodInstance()->getTitle();

        if ($order->getPayment()) {
            $paymentInfo = $order->getPayment()->getMethodInstance()->getTitle();
        }

        $paymentInfoBlock = Mage::helper('payment')->getInfoBlock($order->getPayment());
        $bilSafeBlock = $paymentInfoBlock->toHtml();

        $variables = array(
            'billing_method' => array(
                'value' => $paymentInfo,
                'label' => Mage::helper('sales')->__('Billing Method'),
            ),
            'billing_method_currency' => array(
                'value' => $order->getOrderCurrencyCode(),
                'label' => Mage::helper('sales')->__('Order was placed using'),
            ),
            'ea_payment' => array(
                'value' => $bilSafeBlock,
                'label' => Mage::helper('sales')->__('Bilsafe'),
            ),
        );
        return $variables;
    }

    public function getTheShippingInfo()
    {
        $order = $this->getOrder();


        if ($order->getShippingDescription()) {
            $shippingInfo = $order->getShippingDescription();
        } else {
            $shippingInfo = '';
        }

        $variables = array(
            'shipping_method' => array(
                'value' => $shippingInfo,
                'label' => Mage::helper('sales')->__('Shipping Information'),
            ),
        );
        return $variables;
    }

    public function getTheInfoMergedVariables()
    {
        $vars = array_merge(
            $this->getTheInfoVariables()
            , $this->getTheCustomerVariables()
            , $this->getTheAddresInfo()
            , $this->getThePaymentInfo()
            , $this->getTheShippingInfo()
            , $this->getTheInvoiceVariables()
        );
        $processedVars = Mage::helper('pdfgenerator')->arrayToStandard($vars);

        return $processedVars;
    }

}
