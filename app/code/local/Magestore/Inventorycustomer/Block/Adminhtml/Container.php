<?php

class Magestore_Inventorycustomer_Block_Adminhtml_Container extends Mage_Adminhtml_Block_Template {

    protected function _prepareLayout() {
        return parent::_prepareLayout();
    }

    /**
     * Get data of submited filter
     * 
     * @return array
     */
    public function getRequestData($field = null) {
        if (!$this->hasData('request_data')) {
            $requestData = Mage::helper('adminhtml')->prepareFilterString($this->getRequest()->getParam('top_filter'));
            $this->setData('request_data', $requestData);
        }
        $data = $this->getData('request_data');
        return $field ? (isset($data[$field]) ? $data[$field] : null) : $data;
    }

}
