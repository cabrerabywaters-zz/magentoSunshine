<?php
/**
 * Advanced Permissions
 *
 * @category:    Aitoc
 * @package:     Aitoc_Aitpermissions
 * @version      2.10.9
 * @license:     9DAcmpHmKm5MrRdfs5lugvpF2c0A7dPjtx5lj0JMEV
 * @copyright:   Copyright (c) 2015 AITOC, Inc. (http://www.aitoc.com)
 */
class Aitoc_Aitpermissions_Block_Rewrite_AdminPollGrid extends Mage_Adminhtml_Block_Poll_Grid
{
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('poll/poll')->getCollection();

        $role = Mage::getSingleton('aitpermissions/role');

        if ($role->isPermissionsEnabled())
        {
            $collection->addStoreFilter($role->getAllowedStoreviewIds());
        }

        $this->setCollection($collection);
        Mage_Adminhtml_Block_Widget_Grid::_prepareCollection();

        if (!Mage::app()->isSingleStoreMode())
        {
            $this->getCollection()->addStoreData();
        }
        
        return $this;
    }
}