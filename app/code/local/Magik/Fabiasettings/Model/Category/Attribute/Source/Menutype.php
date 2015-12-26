<?php
class Magik_Fabiasettings_Model_Category_Attribute_Source_Menutype
	extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{	
	protected $_options;
    
	public function getAllOptions()
	{
        return array(
            array('value' => 'noimage', 'label' => Mage::helper('fabiasettings')->__('No Image')),
            array('value' => 'rightimage', 'label' => Mage::helper('fabiasettings')->__('Right Side Image'))
        );
    }
}
