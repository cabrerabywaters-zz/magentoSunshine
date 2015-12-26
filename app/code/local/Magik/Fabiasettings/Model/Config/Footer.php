<?php


class Magik_Fabiasettings_Model_Config_Footer
{

    public function toOptionArray()
    {
        return array(
            array(
	            'value'=>'simple',
	            'label' => Mage::helper('fabiasettings')->__('simple')),
            array(
	            'value'=>'informative',
	            'label' => Mage::helper('fabiasettings')->__('informative')),
        );
    }

}
