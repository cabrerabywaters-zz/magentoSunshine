<?php


class Magik_Fabiasettings_Model_Config_Width
{

    public function toOptionArray()
    {
        return array(
            array(
	            'value' => 'flexible',
	            'label' => Mage::helper('fabiasettings')->__('flexible')),
            array(
	            'value' => 'fixed',
	            'label' => Mage::helper('fabiasettings')->__('fixed')),
        );
    }

}
