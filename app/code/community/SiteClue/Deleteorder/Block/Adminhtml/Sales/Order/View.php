<?php 
/**
 * SiteClue
 * @category   SiteClue
 * @package    SiteClue_Deleteorder
 * @copyright  Copyright (c) 2015-2016 SiteClue. (http://www.siteclue.com)
 * @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */
 
class SiteClue_Deleteorder_Block_Adminhtml_Sales_Order_View extends Mage_Adminhtml_Block_Sales_Order_View 
{
    public function  __construct() {

        parent::__construct();
		$message = Mage::helper('sales')->__('Are you sure you want to delete this order?');
        $this->_addButton('button_id', array(
            'label'     => Mage::helper('Sales')->__('Delete Order'),
            'onclick'   => 'deleteConfirm(\''.$message.'\', \'' . $this->getDeleteUrl() . '\')',
            'class'     => 'go'
        ), 0, 100, 'header', 'header');
    }
	
    public function getDeleteUrl()
    {
        return $this->getUrl('deleteorder/adminhtml_deleteorder/delete', array('_current'=>true));
    }	
}
?>