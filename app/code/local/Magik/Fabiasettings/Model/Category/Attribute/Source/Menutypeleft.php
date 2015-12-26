<?php
class Magik_Fabiasettings_Model_Category_Attribute_Source_Menutypeleft
	extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{	
	protected $_options;
    
	public function getAllOptions()
	{
        return array(
            array('value' => 'noimage', 'label' => Mage::helper('fabiasettings')->__('No Image')),
            array('value' => 'leftimage', 'label' => Mage::helper('fabiasettings')->__('Left Side Image')),
            array('value' => 'leftimagetxt', 'label' => Mage::helper('fabiasettings')->__('Left Side Image With Text')),
            array('value' => 'bottomimage', 'label' => Mage::helper('fabiasettings')->__('Bottom Side Image'))
        );
    }
}
