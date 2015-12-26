<?php


class Magik_Fabiasettings_Model_Config_Position
{

    public function toOptionArray()
    {
        return array(
            array(
	            'value'=>'top-left',
	            'label' => Mage::helper('fabiasettings')->__('Top Left')),
            array(
	            'value'=>'top-right',
	            'label' => Mage::helper('fabiasettings')->__('Top Right')),                       

        );
    }

}
