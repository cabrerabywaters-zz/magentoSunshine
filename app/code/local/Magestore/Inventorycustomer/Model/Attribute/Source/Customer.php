<?php

class Magestore_Inventorycustomer_Model_Attribute_Source_Customer extends Mage_Eav_Model_Entity_Attribute_Source_Abstract {

    const VIP = 1;
    const NORMAL = 2;
    const NOT_SATISFIED = 3;

    protected $_options = null;

    static public function getOptionArray() {
        return array(
            self::VIP => Mage::helper('inventorycustomer')->__('VIP'),
            self::NORMAL => Mage::helper('inventorycustomer')->__('Normal'),
            self::NOT_SATISFIED => Mage::helper('inventorycustomer')->__('Not Satisfied'),
        );
    }

    public function getAllOptions($withEmpty = false) {
        if (is_null($this->_options)) {
            $this->_options = array();

            $this->_options[] = array('label' => 'VIP', 'value' => 1);
            $this->_options[] = array('label' => 'Normal', 'value' => 2);
            $this->_options[] = array('label' => 'Not Satisfied', 'value' => 3);
        }
        $options = $this->_options;
        if ($withEmpty) {
            array_unshift($options, array('value' => '', 'label' => ''));
        }
        return $options;
    }

    public function getOptionText($value) {
        $options = $this->getAllOptions(false);

        foreach ($options as $item) {
            if ($item['value'] == $value) {
                return $item['label'];
            }
        }
        return false;
    }

}
