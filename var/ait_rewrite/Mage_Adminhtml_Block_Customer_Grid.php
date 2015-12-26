<?php
/* DO NOT MODIFY THIS FILE! THIS IS TEMPORARY FILE AND WILL BE RE-GENERATED AS SOON AS CACHE CLEARED. */

/**
 * Advanced Permissions
 *
 * @category:    Aitoc
 * @package:     Aitoc_Aitpermissions
 * @version      2.10.9
 * @license:     9DAcmpHmKm5MrRdfs5lugvpF2c0A7dPjtx5lj0JMEV
 * @copyright:   Copyright (c) 2015 AITOC, Inc. (http://www.aitoc.com)
 */
class Aitoc_Aitpermissions_Block_Rewrite_AdminCustomerGrid extends Mage_Adminhtml_Block_Customer_Grid
{
	protected function _prepareColumns()
	{
		parent::_prepareColumns();

        $role = Mage::getSingleton('aitpermissions/role');

		if ($role->isPermissionsEnabled())
		{
            if (!Mage::helper('aitpermissions')->isShowingAllCustomers() &&
                isset($this->_columns['website_id']))
            {
                unset($this->_columns['website_id']);
                $allowedWebsiteIds = $role->getAllowedWebsiteIds();

                if (count($allowedWebsiteIds) > 1)
                {
                    $websiteFilter = array();
                    foreach ($allowedWebsiteIds as $allowedWebsiteId)
                    {
                        $website = Mage::getModel('core/website')->load($allowedWebsiteId);
                        $websiteFilter[$allowedWebsiteId] = $website->getData('name');
                    }

                    $this->addColumn('website_id', array(
                        'header' => Mage::helper('customer')->__('Website'),
                        'align' => 'center',
                        'width' => '80px',
                        'type' => 'options',
                        'options' => $websiteFilter,
                        'index' => 'website_id',
                    ));
                }
            }
		}
        
        return $this;
	}
}


/**
 * @project     AjaxLogin
 * @package     LitExtension_AjaxLogin
 * @author      LitExtension
 * @email       litextension@gmail.com
 */
class LitExtension_AjaxLogin_Block_Rewrite_Customer_Grid extends Aitoc_Aitpermissions_Block_Rewrite_AdminCustomerGrid
{
    protected $_attributeCollection;

    public function __construct()
    {
        parent::__construct();

//        $this->_attributeCollection = Mage::getModel('eav/entity_attribute')->getCollection();
        $this->_attributeCollection = Mage::getModel('customer/attribute')->getCollection();
        $this->_attributeCollection->getSelect()->join(Mage::getConfig()->getTablePrefix().'le_ajaxlogin_attributes', 'main_table.attribute_id ='.Mage::getConfig()->getTablePrefix().'le_ajaxlogin_attributes.attribute_id',array('attribute_id'));
        $this->_attributeCollection->addFieldToFilter('is_user_defined', 1);
        // 'is_filterable_in_search' used to setting "Show on Manage Customers Grid"
        $this->_attributeCollection->addFieldToFilter('show_on_customer_grid', 1);
        $this->_attributeCollection->addFieldToFilter('entity_type_id', Mage::getModel('eav/entity')->setType('customer')->getTypeId());
        $this->_attributeCollection->getSelect();
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('customer/customer_collection')
            ->addNameToSelect()
            ->addAttributeToSelect('email')
            ->addAttributeToSelect('created_at')
            ->addAttributeToSelect('group_id');

        foreach ($this->_attributeCollection as $attribute)
        {
            $collection->addAttributeToSelect($attribute->getAttributeCode());//var_dump($collection);exit();
        }

        $collection
            ->joinAttribute('billing_postcode', 'customer_address/postcode', 'default_billing', null, 'left')
            ->joinAttribute('billing_city', 'customer_address/city', 'default_billing', null, 'left')
            ->joinAttribute('billing_telephone', 'customer_address/telephone', 'default_billing', null, 'left')
            ->joinAttribute('billing_region', 'customer_address/region', 'default_billing', null, 'left')
            ->joinAttribute('billing_country_id', 'customer_address/country_id', 'default_billing', null, 'left');
        $this->setCollection($collection);

        return Mage_Adminhtml_Block_Widget_Grid::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        parent::_prepareColumns();

        // will backup action column
        $actionColumn = $this->_columns['action'];
        unset($this->_columns['action']);


        foreach ($this->_attributeCollection as $attribute)
        {
            if ($inputType = $attribute->getFrontend()->getInputType())
            {
                switch ($inputType)
                {
                    case 'date':
                        $this->addColumn($attribute->getAttributeCode(), array(
                            'header'    => __($attribute->getFrontend()->getLabel()),
                            'type'      => 'date',
                            'align'     => 'center',
                            'index'     => $attribute->getAttributeCode(),
                            'gmtoffset' => true
                        ));
                        break;
                    case 'text':
                    case 'textarea':
                        $this->addColumn($attribute->getAttributeCode(), array(
                            'header'    => __($attribute->getFrontend()->getLabel()),
                            'index'     => $attribute->getAttributeCode(),
                            'filter'    => 'adminhtml/widget_grid_column_filter_text',
                            'sortable'  => true,
                        ));
                        break;
                    case 'select':
                        $options = array();
                        foreach ($attribute->getSource()->getAllOptions(false, true) as $option)
                        {
                            $options[$option['value']] = $option['label'];
                        }
                        $this->addColumn($attribute->getAttributeCode(), array(
                            'header'    =>  __($attribute->getFrontend()->getLabel()),
                            'index'     =>  $attribute->getAttributeCode(),
                            'type'      =>  'options',
                            'options'   =>  $options,
                        ));
                        break;
                    case 'multiselect':
                        $options = array();
                        foreach ($attribute->getSource()->getAllOptions(false, true) as $option)
                        {
                            $options[$option['value']] = $option['label'];
                        }
                        $this->addColumn($attribute->getAttributeCode(), array(
                            'header'    =>  __($attribute->getFrontend()->getLabel()),
                            'index'     =>  $attribute->getAttributeCode(),
                            'type'      =>  'options',
                            'options'   =>  $options,
                            'renderer'  => 'ajaxlogin/adminhtml_renderer_multiselect',
                            'filter'    => 'ajaxlogin/adminhtml_filter_multiselect',
                        ));
                        break;
                    case 'image':
                        $this->addColumn($attribute->getAttributeCode(), array(
                            'header'    => __($attribute->getFrontend()->getLabel()),
                            'align'     => 'center',
                            'index'     =>  $attribute->getAttributeCode(),
                            'type'      => 'text',
                            'renderer'  => 'ajaxlogin/adminhtml_renderer_file',
                        ));
                        break;
                }
            }
        }

        // restoring action column
        $this->_columns[] = $actionColumn;

        return $this;
    }

}

