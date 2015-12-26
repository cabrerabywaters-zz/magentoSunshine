<?php
/**
 * MageWorx
 * Multi Fees Extension
 *
 * @category   MageWorx
 * @package    MageWorx_MultiFees
 * @copyright  Copyright (c) 2015 MageWorx (http://www.mageworx.com/)
 */

class MageWorx_MultiFees_Block_Adminhtml_Fee extends Mage_Adminhtml_Block_Template
{
    protected function _prepareLayout() {
        $helper = Mage::helper('mageworx_multifees');
        $this->setChild('add_new_button', $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array('label' => $helper->__('Add Fee'),
                    'onclick' => "setLocation('" . $this->getUrl('*/*/new') . "')",
                    'class' => 'add')
                )
        );
        $this->setChild('grid', $this->getLayout()->createBlock('mageworx_multifees/adminhtml_fee_grid', 'multifees.grid'));
        return parent::_prepareLayout();
    }

    /**
     * @return string
     */
    public function getAddNewButtonHtml() {
        return $this->getChildHtml('add_new_button');
    }

    /**
     * @return string
     */
    public function getGridHtml() {
        return $this->getChildHtml('grid');
    }
}