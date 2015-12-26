<?php


class Magik_Fabiasettings_Model_Config_Sidebarmenu
{

    public function toOptionArray()
    {
        return array(
            array(
	            'value'=>'sidebar-classic-menu',
	            'label' => Mage::helper('fabiasettings')->__('Sidebar Classic Menu')),
            array(
	            'value'=>'sidebar-mega-menu',
	            'label' => Mage::helper('fabiasettings')->__('Sidebar Mega Menu')),                       

        );
    }

}
