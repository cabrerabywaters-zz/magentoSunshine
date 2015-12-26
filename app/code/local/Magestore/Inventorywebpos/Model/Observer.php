<?php

/**
 * Magestore
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the Magestore.com license that is
 * available through the world-wide-web at this URL:
 * http://www.magestore.com/license-agreement.html
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category    Magestore
 * @package     Magestore_Inventorywebpos
 * @copyright   Copyright (c) 2012 Magestore (http://www.magestore.com/)
 * @license     http://www.magestore.com/license-agreement.html
 */

/**
 * Inventorywarehouse Observer Model
 * 
 * @category    Magestore
 * @package     Magestore_Inventorywarehouse
 * @author      Magestore Developer
 */
class Magestore_Inventorywebpos_Model_Observer {

    /**
     * process controller_action_predispatch_webpos_index_productsearch event
     *
     * @return Magestore_Inventorywebpos_Model_Observer
     */
    public function initProductSearch($observer) {
        $keyword = Mage::app()->getRequest()->getPost('keyword');
        $barcode = Mage::getModel('inventorybarcode/barcode')->load($keyword, 'barcode');
        $result = array();
        $storeId = Mage::app()->getStore()->getStoreId();
        $showOutofstock = Mage::getStoreConfig('webpos/general/show_product_outofstock', $storeId);
        $productBlock = Mage::getBlockSingleton('catalog/product_list');
        if ($barcode->getId()) {
            $productId = $barcode->getProductEntityId();
            $product = Mage::getModel('catalog/product')->load($productId);
            $addToCart = $productBlock->getAddToCartUrl($product) . 'tempadd/1';
            $result[] = $productId;
            $html = '';
            $html .= '<ul>';
            $html .= '<li id="sku_only" url="' . $addToCart . '" onclick="setLocation(\'' . $addToCart . '\')">';
            $html .= '<strong>' . Mage::getBlockSingleton('core/template')->htmlEscape($product->getName()) . '</strong>-' . Mage::helper('core')->currency($product->getFinalPrice());
            $html .= '<br /><strong>SKU: </strong>' . $product->getSku();
            if ($showOutofstock) {
                $html .= '<br />';
                if ($product->isAvailable()) {
                    $html .= '<p class="availability in-stock">' . Mage::helper('inventorywebpos')->__('Availability:') . '<span>' . Mage::helper('inventorywebpos')->__('In stock') . '</span></p><div style="clear:both"></div>';
                } else {
                    $html .= '<p class="availability out-of-stock">' . Mage::helper('inventorywebpos')->__('Availability:') . '<span>' . Mage::helper('inventorywebpos')->__('Out of stock') . '</span></p><div style="clear:both"></div>';
                }
            }
            $html .= '</li>';
            $html .= '</ul>';
            echo $html;
            return;
        } else {
            $searchInstance = new Magestore_Inventorywebpos_Model_Search_Barcode();
            $results = $searchInstance->setStart(1)
                    ->setLimit(10)
                    ->setQuery($keyword)
                    ->load()
                    ->getResults();

            if (count($results)) {
                $html = '';
                $html .= '<ul>';
                foreach ($results as $item) {
                    $productId = $item['product_id'];
                    $product = Mage::getModel('catalog/product')->load($productId);
                    $addToCart = $productBlock->getAddToCartUrl($product) . 'tempadd/1';
                    $result[] = $product->getId();
                    $html .= '<li onclick="setLocation(\'' . $addToCart . '\')">';
                    $html .= '<strong>' . Mage::getBlockSingleton('core/template')->htmlEscape($product->getName()) . '</strong>-' . Mage::helper('core')->currency($product->getFinalPrice());
                    $html .= '<br /><strong>SKU: </strong>' . $product->getSku();
                    if ($showOutofstock) {
                        $html .= '<br />';
                        if ($product->isAvailable()) {
                            $html .= '<p class="availability in-stock">' . Mage::helper('inventorywebpos')->__('Availability:') . '<span>' . Mage::helper('inventorywebpos')->__('In stock') . '</span></p><div style="clear:both"></div>';
                        } else {
                            $html .= '<p class="availability out-of-stock">' . Mage::helper('inventorywebpos')->__('Availability:') . '<span>' . Mage::helper('inventorywebpos')->__('Out of stock') . '</span></p><div style="clear:both"></div>';
                        }
                    }
                    $html .= '</li>';
                }
                $html .= '</ul>';
                echo $html;
                return;
            }
        }
    }
	public function webposBlockListproductEvent($observer){
		Mage::setIsDeveloperMode(true);
		ini_set('display_errors', 1);
		$warehouseSelected = Mage::helper('inventorywebpos')->_getCurrentWarehouseId();
		$coreResource = Mage::getSingleton('core/resource');
		$readConnection = $coreResource->getConnection('core_read');
		$collection = $observer->getEvent()->getPosGetProductColection();
		$tempTableArr = array('warehouse_products_temp_table');
        Mage::helper('inventorywebpos')->removeTempTables($tempTableArr);
		$w_productCol = Mage::helper('inventorywebpos')->getWarehouseProductCollection($warehouseSelected);
		Mage::helper('inventorywebpos')->createTempTable('warehouse_products_temp_table', $w_productCol);
		$collection->getSelect()
			->joinLeft(
                    array('warehouse_product' => $coreResource->getTableName('warehouse_products_temp_table')), "e.entity_id=warehouse_product.product_id", array('*'));
		$sql = "SELECT DISTINCT(`parent_id`) FROM " . $coreResource->getTableName('catalog/product_super_link')." as `product_sl`";
		$sql .= " JOIN ".$coreResource->getTableName('warehouse_products_temp_table')." as `wp_temp`";
        $sql .= " ON product_sl.product_id = wp_temp.product_id";
        $sql .= " AND wp_temp.available_qty > 0 ";		
		$parent_ids = $readConnection->fetchAll($sql);
		$parentIdArr = array();
		foreach($parent_ids as $parent_id){
			$parentIdArr[] = $parent_id['parent_id'];
		}

		$parentIdStr = implode (',',$parentIdArr);
		if($parentIdStr){
			$collection->getSelect()->where("e.entity_id IN({$parentIdStr}) OR warehouse_product.available_qty > 0");
		}else{
			$collection->getSelect()->where("warehouse_product.available_qty > 0");
		}
	}
    //add webpos permission tab
    public function addWarehouseTab($observer) {
        if (Mage::helper('inventoryplus')->isWebPOS20Active()) {
            $warehouseId = $observer->getWarehouseId();
            if (!$warehouseId)
                return;
            $tab = $observer->getTab();
            $tab->addTab('webpos_permission_section', array(
                'label' => Mage::helper('inventorywebpos')->__('WebPOS Users'),
                'title' => Mage::helper('inventorywebpos')->__('WebPOS Users'),
                'content' => $tab->getLayout()
                        ->createBlock('inventorywebpos/adminhtml_warehouse_edit_tab_webpos_permission', 'adminhtml_warehouse_edit_tab_webpos_permission')
                        ->toHtml()
            ));
        }
        return;
    }
}
