<?php
/**
 * SiteClue
 * @category   SiteClue
 * @package    SiteClue_Deleteorder
 * @copyright  Copyright (c) 2015-2016 SiteClue. (http://www.siteclue.com)
 * @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */
class SiteClue_Deleteorder_Adminhtml_DeleteorderController extends Mage_Adminhtml_Controller_Action
{

  protected function _initOrder()
    {
        $id = $this->getRequest()->getParam('order_id');
        $order = Mage::getModel('sales/order')->load($id);

        if (!$order->getId()) {
            $this->_getSession()->addError($this->__('This order no longer exists.'));
            $this->_redirect('*/*/');
            $this->setFlag('', self::FLAG_NO_DISPATCH, true);
            return false;
        }
        Mage::register('sales_order', $order);
        Mage::register('current_order', $order);
        return $order;
    }
	public function deleteAction() {
		if($order = $this->_initOrder()) {
			try {
     		    $order->delete();
				if($this->_deleteOrder($this->getRequest()->getParam('order_id'))){
					Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Order was successfully deleted'));
					$this->_redirectUrl(Mage::helper('adminhtml')->getUrl('adminhtml/sales_order/index'));
				}
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('order_ids')));
			}
		}
		$this->_redirectUrl(Mage::helper('adminhtml')->getUrl('adminhtml/sales_order/index'));
	}
    public function massDeleteAction() {
        $orderIds = $this->getRequest()->getParam('order_ids');
		if(!is_array($orderIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($orderIds as $orderId) {
					Mage::getModel('sales/order')->load($orderId)->delete()->unsetAll();
					$this->_deleteOrder($orderId);
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($orderIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
		$this->_redirectUrl(Mage::helper('adminhtml')->getUrl('adminhtml/sales_order/index'));
    }
	
	public function _deleteOrder($order_id){
		
		$resource = Mage::getSingleton('core/resource');
        $read = $resource->getConnection('core_read');
		
		$order_tb      = $resource->getTableName('sales_flat_order_grid');
        $invoice_tb    = $resource->getTableName('sales_flat_invoice_grid');
        $shipment_tb   = $resource->getTableName('sales_flat_shipment_grid');
        $creditmemo_tb = $resource->getTableName('sales_flat_creditmemo_grid');
		
		$sql = "DELETE FROM  " . $order_tb . " WHERE entity_id = " . $order_id . ";";
        $read->query($sql);
		$sql = "DELETE FROM  " . $invoice_tb . " WHERE order_id = " . $order_id . ";";
        $read->query($sql);
		$sql = "DELETE FROM  " . $shipment_tb . " WHERE order_id = " . $order_id . ";";
        $read->query($sql);
		$sql = "DELETE FROM  " . $creditmemo_tb . " WHERE order_id = " . $order_id . ";";
        $read->query($sql);
		
		return true;
	}
	
}