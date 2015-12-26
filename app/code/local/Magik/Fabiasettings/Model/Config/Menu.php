<?php


class Magik_Fabiasettings_Model_Config_Menu
{

    public function toOptionArray()
    {
        return array(
            array(
	            'value'=>'classic-menu',
	            'label' => Mage::helper('fabiasettings')->__('Classic Menu')),
            array(
	            'value'=>'mega-menu',
	            'label' => Mage::helper('fabiasettings')->__('Mega Menu')),                       

        );
    }

}
